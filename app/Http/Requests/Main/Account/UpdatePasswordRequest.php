<?php

namespace App\Http\Requests\Main\Account;

use App\Abstracts\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'currentPassword' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages(): array
    {
         return [
             'currentPassword.required' => 'Current password is required',
             'currentPassword.current_password' => 'Current password is wrong',
             'password.required' => 'New password is required',
             'password.confirm' => 'Please confirm new password',
         ];
     }
}
