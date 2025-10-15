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
            'items.*.name'     => 'required|string',
            'items.*.price'    => 'required|numeric',
            'items.*.instructions' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'total_price'      => 'required|numeric|min:0',
            'payment_method'   => 'required|string|in:paypal,cash',
            'payment_details'  => 'required|string',
            'tip'              => 'nullable|numeric|min:0',
            // ✅ New discount fields
            'discount_code' => 'nullable|string|max:50',
        ];
    }
    
}
