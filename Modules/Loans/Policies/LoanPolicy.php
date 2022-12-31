<?php

namespace Modules\Loans\Policies;

use Modules\Users\Models\User;
use Modules\Loans\Models\Loan;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    /* public function view(User $user, Loan $loan)
    {
        return $user->id === $loan->user_id;
    } */
}
