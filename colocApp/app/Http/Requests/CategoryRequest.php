<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only allow the owner of the colocation to create/update categories
        $user = Auth::user();
        $colocation = $user->colocations()->first();

        return $colocation && $user->id === $colocation->owner_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
        ];
    }

    /**
     * Custom messages (optional)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a category name.',
            'name.min' => 'Category name must be at least 2 characters.',
            'name.max' => 'Category name cannot exceed 255 characters.',
        ];
    }
}