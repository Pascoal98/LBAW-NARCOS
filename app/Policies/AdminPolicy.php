<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the admin panel.
     */
    public function show(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view the list of suspended users.
     */
    public function suspensions(User $user)
    {
        return $user->is_admin;
    }

    public function unsuspendUser(User $user) {
        return Auth::user()->is_admin;
    }


    public function suspendUser(User $user) {
        return Auth::user()->is_admin;
    }


    /**
     * Determine whether the user can view the list of reports.
     */
    public function reports(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can manage t.
     */
    public function topics(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can close reports.
     */
    public function closeReport(User $user, Report $report)
    {
        return $user->is_admin && $report->reported_id !== $user->id;
    }
}