<?php

namespace Modules\Loans\Services;

use Modules\Loans\Models\{Loan};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;

class LoanService
{
    function getLoansByRole(array $arr) {
        $loan = new Loan();

        if (Auth::user()->role == Roles::CUSTOMER) //Fetch loan details of logged in user if the role is not admin
            $loan = $loan->where('user_id', Auth::user()->id);
    
        $loan = $loan->filter($arr)->get();

        if (count($loan) < 1)
            throw new \Exception('No records found');
        return $loan;
    }

    function createLoan(array $arr) : Loan {
        return Loan::create([
            'user_id' => Auth::user()->id,
            'loan_date' => $arr['loan_date'],
            'loan_number' => $arr['loan_number'],
            'amount' => $arr['amount'],
            'term' => $arr['term']
        ]);
    }

    function updateLoan(array $arr, Loan $loan) : Loan {
        if ($loan->status != 'PENDING')
            throw new \Exception('Loan status already updated');

        $loan->status = isset($arr['status']) ? $arr['status'] : $loan->status;
        $loan->save();
        return $loan;
    }

}