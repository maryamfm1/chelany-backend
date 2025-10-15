<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // permission checks baad mein karenge
    }

    public function rules()
{
    return [
        'name_en' => 'required|string|max:255|unique:categories,name_en',
        'name_de' => 'required|string|max:255|unique:categories,name_de',
    ];
}

}
