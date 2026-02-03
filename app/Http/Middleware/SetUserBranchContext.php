<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Services\BranchContextManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SetUserBranchContext
 *
 * Sets the branch context based on the authenticated user's branch_id OR
 * an admin-selected session context (BranchSwitcher).
 *
 * - Normal users: scoped to their own branch.
 * - Super Admin / branches.view-all users: can scope to a specific branch (session value),
 *   or choose "All Branches" (session value 0) which disables branch scoping.
 *
 * This ensures models using HasBranch trait automatically scope queries to the
 * current context, preventing cross-branch data leakage and keeping UI + backend consistent.
 */
class SetUserBranchContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $branchId = $this->resolveBranchId($user);

        // When branchId is null, it means "All Branches" (no scoping) for privileged users.
        if ($branchId) {
            // Store on request attributes
            $request->attributes->set('branch_id', $branchId);

            // Store in container (used by helpers/services)
            app()->instance('req.branch_id', $branchId);

            // Ensure BranchContextManager knows the explicit context for this request (write operations)
            BranchContextManager::setBranchContext($branchId);

            // Store branch model in request attributes if available
            $branch = $this->resolveBranch($user, $branchId);
            if ($branch) {
                $request->attributes->set('branch', $branch);
            }
        }

        return $next($request);
    }

    /**
     * Resolve the effective branch ID for the current request.
     *
     * Returns:
     * - int branch id: scope the request to that branch
     * - null: "All Branches" (no scope) for privileged users
     */
    private function resolveBranchId(object $user): ?int
    {
        $canSwitchBranches = $this->canSwitchBranches($user);

        if ($canSwitchBranches) {
            // Keep a consistent session key for switchable users.
            // 0 is the sentinel for "All Branches".
            if (! session()->exists('admin_branch_context')) {
                session(['admin_branch_context' => (int) ($user->branch_id ?? 0)]);
            }

            $sessionBranchId = (int) session('admin_branch_context', 0);

            // 0 => All Branches (no branch context)
            if ($sessionBranchId === 0) {
                return null;
            }

            // Validate the session branch ID is valid and active
            $branchExists = Branch::query()
                ->where('id', $sessionBranchId)
                ->where('is_active', true)
                ->exists();

            if ($branchExists) {
                return $sessionBranchId;
            }

            // Invalid session branch - reset to user's branch (or 0 if none)
            session(['admin_branch_context' => (int) ($user->branch_id ?? 0)]);
        }

        // Fallback: user's primary branch
        if (isset($user->branch_id) && $user->branch_id) {
            return (int) $user->branch_id;
        }

        return null;
    }

    /**
     * Check if user has permission to switch branches.
     */
    private function canSwitchBranches(object $user): bool
    {
        if (method_exists($user, 'hasRole') && $user->hasRole('Super Admin')) {
            return true;
        }

        if (method_exists($user, 'can')) {
            // Prefer canonical permission...
            if ($user->can('branches.view-all')) {
                return true;
            }

            // Legacy alias used in some deployments.
            if ($user->can('access-all-branches')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolve the branch model for the given branch ID.
     */
    private function resolveBranch(object $user, int $branchId): ?Branch
    {
        // If the resolved branch is user's own branch and it's loaded, use it
        if (isset($user->branch_id) && (int) $user->branch_id === (int) $branchId) {
            if ($user->relationLoaded('branch')) {
                return $user->branch;
            }

            if (method_exists($user, 'branch')) {
                return $user->branch()->first();
            }
        }

        return Branch::find($branchId);
    }
}
