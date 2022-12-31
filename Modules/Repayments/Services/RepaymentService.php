<?php

namespace Modules\Repayments\Services;

use Modules\Repayments\Models\{Repayment};
use Modules\Loans\Models\{Loan};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
use DB;
class RepaymentService
{
    function getRepaymentsByRole(array $arr) {
        $repayment = new Repayment();

        if (Auth::user()->role == Roles::CUSTOMER) //Fetch repayment details of logged in user if the role is not admin
            $repayment = $repayment->where('user_id', Auth::user()->id);
    
        $repayment = $repayment->filter($arr)->get();

        if (count($repayment) < 1)
            throw new \Exception('No records found');
        return $repayment;
    }

    function createRepayment(array $arr)  {

        DB::beginTransaction();
            $loan = Loan::with('first_scheduled_repayment')->where('id',$arr['loan_id'])->first();
            
            if ($loan->status == 'PAID' || $loan->status == 'REJECTED')
                throw new \Exception('Repayment can be collected only for active loans.');

            if (empty($loan->first_scheduled_repayment))
                throw new \Exception('Repayment can be collected only for active scheduled payments.');    

            if ($arr['amount'] < $loan->first_scheduled_repayment->amount)
                throw new \Exception('Repayment amount should be higher than the scheduled payment amount.');

            $repayment = Repayment::create([
                'loan_amount_paid' => $arr['amount'],
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'status' => 'SUCCESS'
            ]);

            if ($repayment->loan_amount_paid >= $loan->first_scheduled_repayment->amount) {
                $loan->first_scheduled_repayment->status = 'PAID';
                $loan->first_scheduled_repayment->save();    
            }

            $this->realiseLoanRepayment($loan, $repayment);

        DB::commit();
        return $loan->refresh();
    }

    function realiseLoanRepayment(Loan $loan, Repayment $repayment) {
        $loan->load('first_scheduled_repayment');
        if (empty($loan->first_scheduled_repayment)) {
            $loan->status = 'PAID';
            $loan->save();
        }
    }

}