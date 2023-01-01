<?php

namespace Modules\Repayments\Tests\Unit;

use Tests\TestCase;
use Modules\Users\Services\UserService;
use Modules\Loans\Services\LoanService;
use Modules\Repayments\Services\RepaymentService;
use Faker\Factory;
use Modules\Users\Models\{User};
use Modules\Repayments\Models\{Repayment};
use Modules\Loans\Models\{Loan};
use Illuminate\Http\Request;
use Modules\Users\Tests\Unit\UserTest;
use Modules\Loans\Tests\Unit\LoanTest;
use Illuminate\Support\Facades\Auth;
class RepaymentTest extends TestCase
{
    public function testCreateLoanRepayment()
    {
        $loan = (new LoanTest)->testCreateLoan();
        
        $arr['amount'] = ceil($loan->amount/3);
        $arr['loan_id'] =$loan->id;

        //Create Loan repayment
        $loan = (new RepaymentService)->createRepayment($arr); // first payment
        $loan = (new RepaymentService)->createRepayment($arr); // second payment
        $loan = (new RepaymentService)->createRepayment($arr); // third payment

        $this->assertNotEmpty($loan);
        $this->assertDatabaseHas('repayments', ['loan_id' => $loan->id, 'loan_amount_paid' => $arr['amount']]);

        return $arr;
    }

    function testGetRepayments() {
        $repayments = (new RepaymentService)->getRepaymentsByRole([]);
        $this->assertNotEmpty($repayments);
    }
}
