<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ReportTemplate;
use App\Models\User;
use App\Policies\Concerns\ChecksPermissions;

/**
 * ReportTemplatePolicy - Authorization for system report templates
 *
 * V58-AUTH-01: Permission-based authorization pattern.
 * Report templates are system-wide configuration resources.
 * Access is controlled via 'reports.templates.manage' permission.
 */
class ReportTemplatePolicy
{
    use ChecksPermissions;

    /**
     * Determine if the user can view any report templates.
     */
    public function viewAny(User $user): bool
    {
        // Users with any report-related permission can view templates
        return $this->has($user, 'reports.view')
            || $this->has($user, 'reports.templates.manage');
    }

    /**
     * Determine if the user can view the report template.
     */
    public function view(User $user, ReportTemplate $reportTemplate): bool
    {
        return $this->has($user, 'reports.view')
            || $this->has($user, 'reports.templates.manage');
    }

    /**
     * Determine if the user can create report templates.
     */
    public function create(User $user): bool
    {
        return $this->has($user, 'reports.templates.manage');
    }

    /**
     * Determine if the user can update the report template.
     */
    public function update(User $user, ReportTemplate $reportTemplate): bool
    {
        return $this->has($user, 'reports.templates.manage');
    }

    /**
     * Determine if the user can delete the report template.
     */
    public function delete(User $user, ReportTemplate $reportTemplate): bool
    {
        return $this->has($user, 'reports.templates.manage');
    }
}
