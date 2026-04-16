<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required","string","min:3",Rule::unique('products','name')],
            "price" => "required|numeric|max:150000",
            "stock" => "required|integer|max:200",
            "desc" => "required|string|min:10",
            "brand" => "required|string",
            "category" => "required|string",
            "image" => "required|image|mimes:jpg,png,jpeg,webp"
        ];
    }
}
