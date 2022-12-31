<?php

namespace Modules\Loans\Services;

use Modules\Loans\Models\{Loan,ScheduledLoanRepayments};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
use DB;
class LoanService
{
    function getLoansByRole(array $arr) {
        $loan = Loan::with('scheduled_repayments');

        if (Auth::user()->role == Roles::CUSTOMER) //Fetch loan details of logged in user if the role is not admin
            $loan = $loan->where('user_id', Auth::user()->id);
    
        $loan = $loan->filter($arr)->get();

        if (count($loan) < 1)
            throw new \Exception('No records found');
        return $loan;
    }

    function createLoan(array $arr) : Loan {
        DB::beginTransaction();
            //inserting loan
            $loan = Loan::create([
                'user_id' => Auth::user()->id,
                'loan_date' => $arr['loan_date'],
                'amount' => $arr['amount'],
                'term' => $arr['term']
            ]);

            //preparing scheduled_repayments model for insertion
            foreach($arr['scheduled_repayments'] as $k => $payments) {
               $arr['temp'][$k] = new ScheduledLoanRepayments($payments);
            }

            //inserting scheduled_repayments 
            $loan->scheduled_repayments()->saveMany($arr['temp']);

            $loan->refresh();
            $loan->load('scheduled_repayments');

        DB::commit();
        return $loan;
    }

    function updateLoan(array $arr, Loan $loan) : Loan {
        if ($loan->status != 'PENDING')
            throw new \Exception('Loan status already updated');

        $loan->status = isset($arr['status']) ? $arr['status'] : $loan->status;
        $loan->save();
        return $loan;
    }

}