<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('id') ?? auth('web')->id();
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('customers','email')->ignore($id)],
            'login_id' => ['required','string','max:64', Rule::unique('customers','login_id')->ignore($id)],
            'password' => ['nullable','string','min:8','confirmed'],
        ];
    }
}
