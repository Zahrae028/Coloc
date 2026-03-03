<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InvitationRequest extends FormRequest
{
   
    
    public function authorize()
    {
        // Only logged-in users can send invitations
        return Auth::check();
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'You must enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
        ];
    }
}

