<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthSignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name' => 'required|max:100',
            'address1' => 'required|max:255',
            'address2' => 'max:255',
            'city' => 'required|max:100',
            'state' => 'required|max:100',
            'country' => 'required|max:100',
            'phone_no1' => 'required|max:20',
            'phone_no2' => 'max:20',
            'zip' => 'required|max:20',
            'user.first_name' => 'required|max:50',
            'user.last_name' => 'required|max:50',
            'user.email' => 'required|max:150|unique:users,email',
            'user.password' => 'required|min:6|confirmed',
            'user.password_confirmation' => 'required|min:6',
            'user.phone' => 'required|max:20'
        ];
    }
}
