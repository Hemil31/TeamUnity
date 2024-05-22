<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100',
            'website' => 'required|url|max:255',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Company name is required.',
            'name.string' => 'Company name must be a string.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'logo.required' => 'Logo is required.',
            'logo.image' => 'Logo must be an image.',
            'logo.mimes' => 'Logo must be a file of type: jpeg, png, jpg.',
            'logo.dimensions' => 'Logo must be at least 100x100 pixels.',
            'website.required' => 'Website is required.',
            'website.url' => 'Website must be a valid URL.',
            
        ];
    }
}
