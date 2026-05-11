<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class addReviewsRequest extends FormRequest
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
            "product_id"=> "required|integer|exists:Product.id",
            "user_id"=> "required|integer|exists:User.id",
            "comment"=> "nullable|string|min:4",
            "rating"=> "required|integer|min:0"
        ];
    }
}
