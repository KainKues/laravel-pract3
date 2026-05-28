<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number'=>['required','unique:rooms,room_number'],
            'capacity'=>['required', 'max:4', 'min:1'],
            'floor'=>['required', 'min:1'],
        ];
    }
}

