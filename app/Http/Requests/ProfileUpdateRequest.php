<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_number' => ['nullable', 'string', 'max:50', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // Max 2MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'profile_image.image' => 'The profile image must be an image file.',
            'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif, webp.',
            'profile_image.max' => 'The profile image must not be larger than 2MB.',
            'phone_number.regex' => 'The phone number format is invalid.',
        ];
    }
}
