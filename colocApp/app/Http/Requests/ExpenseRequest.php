<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|min:0.01',
            'paid_by' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}