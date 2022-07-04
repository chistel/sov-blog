<?php

namespace App\Http\Requests\Main\Account;

use App\Abstracts\Http\FormRequest;
use Platform\Support\Traits\Common\SanitizeEmail;
use Platform\Support\Traits\Common\SanitizePhoneNumber;

class UpdateBasicRequest extends FormRequest
{
    use SanitizePhoneNumber;
    use SanitizeEmail;

    public function all($keys = null)
    {
        $input = parent::all();

        return $this->sanitizeEmail('email', $input);
    }

    public function rules()
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => 'required|email|unique:users,email,' . $this->user()->id . ',id',
           // 'email' => 'nullable|email|unique:users',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'firstName.required' => 'First name is required',
            'lastName.required' => 'Last name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please use a valid email address',
            'email.unique' => 'Email already in use',
        ];
    }
}
