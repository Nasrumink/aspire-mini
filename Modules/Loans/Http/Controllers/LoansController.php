<?php

namespace Modules\Loans\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Loans\Models\Loan;
use Modules\Loans\Http\Requests\{LoanRequest};
use Modules\Loans\Services\LoanService;
class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request) {
        $loans =  (new LoanService)->getLoansByRole($request->all());
        return response()->json(["error" => false, "message" => "Success", "data" => $loans], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LoanRequest $request) {
        $loan =  (new LoanService)->createLoan($request->all());
        return response()->json([
            'error' => false,
            'message' => 'Loan Created Successfully',
            'data' => $loan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Loan $loan, LoanRequest $request) {
        $loan =  (new LoanService)->updateLoan($request->all(), $loan);
        return response()->json([
            'error' => false,
            'message' => 'Loan Updated Successfully',
            'data' => $loan
        ], 200);
    }

}
