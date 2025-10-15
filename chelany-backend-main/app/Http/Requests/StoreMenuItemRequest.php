<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Yahan validation rules define kiye gaye hain jo menu item create/update ke waqt use honge.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'category_id' => 'required|exists:categories,id',
        'name_en' => 'required|string|max:255',
        'name_de' => 'required|string|max:255',
        'description_en' => 'nullable|string',
        'description_de' => 'nullable|string',
        'price' => 'required|numeric|min:0',
    ];
}

}
