<?php

namespace App\Http\Controllers;

class MessagesController extends Controller
{
    public static function messages(): array
    {
        return [
            'required' => 'The :attribute field is required',
            'string' => 'The :attribute field must be String',
            'numeric' => 'The :attribute field must be Numeric',
            'email' => 'The :attribute field is invalid format',
            'min' => 'The :attribute field must be at least :min characters',
            'confirmed' => 'The :attribute field is not the same with confirmation field',
            'file' => 'The :attribute field must be File',
            'image' => 'The :attribute field must be Image',
        ];
    }
}
