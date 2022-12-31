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
    public function index(Request $request)
    {
        $users = Loan::filter($request->all())->get();
        return response()->json(["error" => false, "message" => "Success", "data" => $users], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('loans::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LoanRequest $request)
    {
        $loan =  (new LoanService)->createOrUpdateLoan($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Loan Created Successfully',
            'data' => $loan
        ], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('loans::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('loans::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Loan $loan, LoanRequest $request)
    {
        $loan =  (new LoanService)->createOrUpdateLoan($request->all(), $loan);

        return response()->json([
            'error' => false,
            'message' => 'User Updated Successfully',
            'data' => $loan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
