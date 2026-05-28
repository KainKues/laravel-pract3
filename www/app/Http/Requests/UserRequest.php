<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>['string', 'required'],
            'email'=>['email','required'],
            'password'=>['required'],
            'role' => ['required', 'in:warden,admin']
        ];
    }
}

