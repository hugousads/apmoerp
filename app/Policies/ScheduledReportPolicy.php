<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ScheduledReport;
use App\Models\User;
use App\Policies\Concerns\ChecksPermissions;

/**
 * ScheduledReportPolicy - Authorization for user-scheduled reports
 *
 * V58-AUTH-01: Owner-or-admin authorization pattern.
 * - Owner can view, update, delete their own scheduled reports.
 * - Admin with 'reports.scheduled.manage' permission can manage all scheduled reports.
 */
class ScheduledReportPolicy
{
    use ChecksPermissions;

    /**
     * Determine if the user can view any scheduled reports.
     */
    public function viewAny(User $user): bool
    {
        // Users can always view (list) their own scheduled reports
        // Admin permission allows viewing all
        return true;
    }

    /**
     * Determine if the user can view the scheduled report.
     */
    public function view(User $user, ScheduledReport $scheduledReport): bool
    {
        // Owner can view their own report
        if ($scheduledReport->user_id === $user->id) {
            return true;
        }

        // Admin can view any report
        return $this->has($user, 'reports.scheduled.manage');
    }

    /**
     * Determine if the user can create scheduled reports.
     */
    public function create(User $user): bool
    {
        return $this->has($user, 'reports.scheduled.create')
            || $this->has($user, 'reports.scheduled.manage');
    }

    /**
     * Determine if the user can update the scheduled report.
     */
    public function update(User $user, ScheduledReport $scheduledReport): bool
    {
        // Owner can update their own report
        if ($scheduledReport->user_id === $user->id) {
            return true;
        }

        // Admin can update any report
        return $this->has($user, 'reports.scheduled.manage');
    }

    /**
     * Determine if the user can delete the scheduled report.
     */
    public function delete(User $user, ScheduledReport $scheduledReport): bool
    {
        // Owner can delete their own report
        if ($scheduledReport->user_id === $user->id) {
            return true;
        }

        // Admin can delete any report
        return $this->has($user, 'reports.scheduled.manage');
    }
}
