<?php

namespace Modules\Repayments\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
class RepaymentRequest extends FormRequest
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
                'loan_id' => 'required|exists:loans,id,user_id,'.Auth::user()->id,
            ];
        }

        return [];
    }

}
