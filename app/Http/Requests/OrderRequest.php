<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sab users ko allow karna
    }

    public function rules()
{
    return [
        'name'             => 'required|string|max:255',
        'email'            => 'required|email',
        'phone'            => 'required|string',
        'address'          => 'required|string',
        'items'            => 'required|array',
        // 'items.*.id'       => 'required|integer',  // <- is line ko hata do
        'items.*.quantity' => 'required|integer|min:1',
        'total_price'      => 'required|numeric|min:0',
        'payment_method'   => 'required|string|in:paypal,cash',
        'payment_details'  => 'required|string',
    ];
}

}
