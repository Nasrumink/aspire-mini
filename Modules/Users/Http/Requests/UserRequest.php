<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() == 'DELETE' && Auth::user()->role != Roles::ADMIN) {
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
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required|in:ADMIN,CUSTOMER'
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
