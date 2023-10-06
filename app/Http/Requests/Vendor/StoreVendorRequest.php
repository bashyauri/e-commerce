<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
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
            'brand_id' => ['required'],
            'product_name' => ['required'],
            'short_descp' => ['required'],
            'long_descp' => ['nullable'],
            'sub_category_id' => ['required'],
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'selling_price' => ['required'],
            'product_code' => ['required'],
            'product_qty' => ['required'],
            'product_tags' => ['string', 'nullable'],
            'product_color' => ['string', 'nullable'],
            'product_size' => ['nullable'],
            'discount_price' => ['nullable'],
            'long_dscp' => ['nullable'],
            'category_id' => ['required'],
            'hot_deals' => ['nullable'],
            'featured' => ['nullable'],
            'special_offer' => ['nullable'],
            'special_deals' => ['nullable'],


            'product_thumbnail' => ['required', 'mimes:png,jpg,webp', 'max:5024'],
        ];
    }
}
