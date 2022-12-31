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
     * @param Request $request
     * @return Renderable
     * @path GET /api/v1/repayment
     */
    public function index(Request $request)
    {
        $repayment =  (new RepaymentService)->getRepaymentsByRole($request->all());
        return response()->json(["error" => false, "message" => "Success", "data" => $repayment], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param RepaymentRequest $request
     * @return Renderable
     * @path POST /api/v1/repayment
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

}
