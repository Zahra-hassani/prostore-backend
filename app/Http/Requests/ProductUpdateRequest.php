<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            "name" => ["nullable","string","min:3"],
            "stock" => "nullable|integer|max:200",
            "price" => "nullable|numric|max:150000",
            "brand" => "nullable|string",
            "category" => "nullable|string",
            "description" => "nullable|string|max:10",
            "image1" => "nullable|image|mimes:jpg,png,jpeg,gif,webp",
            "image2" => "nullable|image|mimes:jpg,png,jpeg,gif,webp",
        ];
    }
}
