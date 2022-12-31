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
                'amount' => 'required|numeric',
                'term' => 'required|numeric',
                'repayment_frequency' => 'required|in:WEEKLY,MONTHLY',
            ];
        }

        if ($this->method() == 'PATCH') {
            return [
                'first_name' => 'nullable',
                'last_name' => 'nullable',
                'role' => 'nullable|in:ADMIN,CUSTOMER'
            ];
        }

        return [];
    }

}
