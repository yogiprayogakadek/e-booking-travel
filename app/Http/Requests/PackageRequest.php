<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'address' => 'required',
            'detail' => 'required',
            // 'total' => 'required|numeric',
        ];

        if(Request::instance()->has('id')) {
            $rules += [
                'is_active' => 'nullable',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
        } else {
            $rules += [
                'is_active' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
        }

        return $rules;
    }
}
