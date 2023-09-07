<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddSubCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'category_id' => ['required'],
            'subcategory_name' => ['required', 'unique:sub_categories'],

        ];
    }
}
