<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProvider2EmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'usrname' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:M,F,B',
            'phone' => 'nullable|string|max:20'
        ];
    }
}
