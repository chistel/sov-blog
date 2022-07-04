<?php

namespace App\Http\Requests\Main\Auth;

use App\Abstracts\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'password' => ['required', 'confirmed'],
            'email' => 'nullable|email|unique:users',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [

        ];
    }

}
