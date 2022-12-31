<?php

namespace Modules\Loans\Services;

use Modules\Loans\Models\{Loan};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;

class LoanService
{
    function getUsersByRole(array $arr) {
        $user = new User();

        if (Auth::user()->role == Roles::CUSTOMER) //Fetch user details of logged in user if the role is not admin
            $user = $user->where('id', Auth::user()->id);
    
        return $user->filter($arr)->get();
    }

    function createOrUpdateLoan(array $arr, $loan = '') {
        if (empty($loan))
            $loan = new Loan();
        
        $loan->loan_date = empty($loan->user_id) ? now() : $loan->user_id;   
        $loan->user_id = empty($loan->user_id) ? Auth::user()->id : $loan->user_id;
        $loan->amount = isset($arr['amount']) ? $arr['amount'] : $loan->amount;
        $loan->term = isset($arr['term']) ? $arr['term'] : $loan->term;
        $loan->repayment_frequency = isset($arr['repayment_frequency']) ? $arr['repayment_frequency'] : $loan->repayment_frequency;
        $loan->save();

        return $loan;
    }

}