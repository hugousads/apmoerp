<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * BranchAdminsSeeder
 *
 * Ensures the branch_admins table is populated for common demo/dev setups.
 * Some admin features expect BranchAdmin rows to exist (per-branch permissions).
 */
class BranchAdminsSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::query()->get(['id']);
        if ($branches->isEmpty()) {
            return;
        }

        // Prefer the seeded Branch Administrator user.
        $adminUser = User::query()->where('email', 'branch.admin@ghanem-erp.com')->first();

        // Fallback: first user that has the Admin role.
        if (! $adminUser) {
            $adminUser = User::query()
                ->whereHas('roles', fn ($q) => $q->where('name', 'Admin'))
                ->first();
        }

        if (! $adminUser) {
            return;
        }

        foreach ($branches as $branch) {
            BranchAdmin::updateOrCreate(
                [
                    'branch_id' => $branch->id,
                    'user_id' => $adminUser->id,
                ],
                [
                    'can_manage_users' => true,
                    'can_manage_roles' => true,
                    'can_view_reports' => true,
                    'can_export_data' => true,
                    'can_manage_settings' => true,
                    'is_primary' => (int) ($adminUser->branch_id ?? 0) === (int) $branch->id,
                    'is_active' => true,
                ]
            );
        }
    }
}
