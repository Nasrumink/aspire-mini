<?php

namespace Modules\Loans\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Loans\Models\Loan;
use Modules\Loans\Http\Requests\{LoanRequest};
use Modules\Loans\Services\LoanService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class LoansController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     * @path GET /api/v1/loan
     */
    public function index(Request $request) 
    {
        $loans =  (new LoanService)->getLoansByRole($request->all());
        return response()->json(["error" => false, "message" => "Success", "data" => $loans], 200);
    }

    /**
     * View of the resource.
     * @param Loan $loan
     * @return Renderable
     * @path GET /api/v1/loan
     */
    public function show(Loan $loan) 
    {
        $this->authorize($loan,Auth::user());
        return response()->json(["error" => false, "message" => "Success", "data" => $loan], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param LoanRequest $request
     * @return Renderable
     * @path POST /api/v1/loan
     */
    public function store(LoanRequest $request) 
    {
        $loan =  (new LoanService)->createLoan($request->all());
        return response()->json([
            'error' => false,
            'message' => 'Loan Created Successfully',
            'data' => $loan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param LoanRequest $request
     * @param Loan $loan
     * @return Renderable
     * @path PATCH /api/v1/loan
     */
    public function update(Loan $loan, LoanRequest $request) 
    {
        $loan =  (new LoanService)->updateLoan($request->all(), $loan);
        return response()->json([
            'error' => false,
            'message' => 'Loan Updated Successfully',
            'data' => $loan
        ], 200);
    }

}
