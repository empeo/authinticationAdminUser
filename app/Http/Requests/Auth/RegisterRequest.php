<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name"=>"required|string",
            "email"=>"required|unique:users,email",
            "password"=>"required|min:8",
            "conipassword"=>"required|same:password",
            "phone"=>"required|numeric|regex:/^[0-9]{11}$/",
            "gender"=>"required|in:male,female",
            "image"=>"required|mimes:png,jpg,jpeg|max:1024",
        ];
    }
}
