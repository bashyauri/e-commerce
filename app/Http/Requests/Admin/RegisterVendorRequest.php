<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterVendorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required',   'unique:users,phone'],
            'email' => ['required',  'max:255', 'unique:' . User::class],
            'vendor_join' => ['required'],
            'password' => 'required|same:confirm_password|min:8|string',

        ];
    }
}
