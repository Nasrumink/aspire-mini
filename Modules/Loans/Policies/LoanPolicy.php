<?php

namespace Modules\Loans\Policies;

use Modules\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Loans\Models\Loan;

class LoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user,Loan $loan)
    {
        //dd($loan->user_id);
        return $user->id == $loan->user_id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Modules\Loans\Models\Loan  $loan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Loan $loan)
    {
        return $user->id == $loan->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Modules\Loans\Models\Loan  $loan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Loan $loan)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Modules\Loans\Models\Loan  $loan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Loan $loan)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Modules\Loans\Models\Loan  $loan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Loan $loan)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Modules\Loans\Models\Loan  $loan
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Loan $loan)
    {
        return true;
    }
}
