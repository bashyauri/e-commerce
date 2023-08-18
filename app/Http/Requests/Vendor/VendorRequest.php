<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'email' => ['required', 'email'],
            'phone' => ['nullable'],
            'address' => ['nullable'],
            'vendor_short_info' => ['nullable'],
            'vendor_join' => ['nullable'],
            'photo' => ['nullable', 'file', 'mimes:png,jpg', 'max:5024']
        ];
    }
}
