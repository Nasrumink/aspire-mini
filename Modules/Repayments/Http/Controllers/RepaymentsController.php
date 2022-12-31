<?php

namespace Modules\Repayments\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Repayments\Services\RepaymentService;
use Modules\Repayments\Http\Requests\RepaymentRequest;
class RepaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $repayment =  (new RepaymentService)->getRepaymentsByRole($request->all());
        return response()->json(["error" => false, "message" => "Success", "data" => $repayment], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('repayments::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RepaymentRequest $request)
    {
        $repayment =  (new RepaymentService)->createRepayment($request->all());
        return response()->json([
            'error' => false,
            'message' => 'Repayment Created Successfully',
            'data' => $repayment
        ], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('repayments::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('repayments::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
