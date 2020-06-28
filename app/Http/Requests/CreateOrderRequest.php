<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "firstName"      => "required",
            "lastName"       => "required",
            "middleName"     => "required",
            "email"          => "required|email",
            "phone"          => "required",
            "orders.*.id"    => "required|integer|exists:product,id",
            "orders.*.count" => "required|integer|min:0",
        ];
    }
}
