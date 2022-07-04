<?php

namespace App\Http\Requests\Main\Auth;

use App\Abstracts\Http\FormRequest;
use Platform\Support\Traits\Common\SanitizeEmail;

class LoginRequest extends FormRequest
{
    use SanitizeEmail;

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $input = parent::all();

        return $this->sanitizeEmail('login', $input);
    }

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
            'identity' => 'required|email',
            'password' => 'required|string',
        ];
    }


    public function messages()
    {
        return [
            'identity.required' => 'Login identity is required',
            'identity.email' => 'Email address is invalid',
            'password.required' => 'Password is required',
        ];
    }
}
