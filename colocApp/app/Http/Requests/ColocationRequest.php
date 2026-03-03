<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ColocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'status' => 'sometimes|in:active,cancelled',
            'owner' => 'sometimes|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Colocation name is required.',
            'name.min' => 'Colocation name must be at least 3 characters.',
            'status.in' => 'Status must be either active or cancelled.',
            'owner.exists' => 'Selected owner is invalid.',
        ];
    }
}
