<?php

namespace App\Http\Requests\Main\Auth;

use App\Abstracts\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token'            => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
