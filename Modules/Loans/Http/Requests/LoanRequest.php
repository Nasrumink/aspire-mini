<?php

namespace Modules\loans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() == 'POST' && Auth::user()->role != Roles::CUSTOMER) {
            return false;
        }

        if ($this->method() == 'PATCH' && Auth::user()->role != Roles::ADMIN) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'amount' => 'required|nullable|regex:/^\d+(\.\d{1,2})?$/|gt:1',
                'term' => 'required|numeric',
                'loan_date' => 'required|date',
                'scheduled_repayments' => 'required|array|min:3|max:3',
                'scheduled_repayments.*.amount' => 'required|nullable|regex:/^\d+(\.\d{1,2})?$/|gt:1',
                'scheduled_repayments.*.payment_date' => 'required|date',
            ];
        }

        if ($this->method() == 'PATCH') {
            return [
                'status' => 'required|in:APPROVED,REJECTED'
            ];
        }

        return [];
    }

}
