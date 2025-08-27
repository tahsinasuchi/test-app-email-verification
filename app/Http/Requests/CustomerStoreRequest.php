<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:customers,email'],
            'login_id' => ['required','string','max:64','unique:customers,login_id'],
            'password' => ['required','string','min:8','confirmed'],
        ];
    }
}
