<?php

namespace App\Http\Requests\Main\Auth;

use App\Abstracts\Http\FormRequest;

class PasswordReminderRequest extends FormRequest
{

    public function rules(): array
    {
        return ['identity' => 'required|email'];
    }

    public function authorize()
    {
        return true;
    }
}
