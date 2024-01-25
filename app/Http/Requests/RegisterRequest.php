<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required|same:password',
            'phone' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];

        return $rules;
    }
}
