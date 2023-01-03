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
     * Check whether the user can view the admin panel.
     */
    public function show(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check whether the user can view the list of suspended users.
     */
    public function suspensions(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check if the user can remove the suspension of an user
     */
    public function unsuspendUser(User $user) {
        return Auth::user()->is_admin;
    }

    /**
     * Check of the user can suspend another user
     */
    public function suspendUser(User $user) {
        return Auth::user()->is_admin;
    }


    /**
     * Check whether the user can view the list of reports.
     */
    public function reports(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check whether the user can manage topics.
     */
    public function topics(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check whether the user can close reports.
     */
    public function closeReport(User $user, Report $report)
    {
        return $user->is_admin && $report->reported_id !== $user->id;
    }
}