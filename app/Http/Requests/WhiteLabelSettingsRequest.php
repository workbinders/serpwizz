<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhiteLabelSettingsRequest extends FormRequest
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
            'domain_name' => 'required',
            'audit_report_title' => 'required',
            'header_big_logo' => 'image|mimes:jpeg,png,jpg',
            'header_small_logo' => 'image|mimes:jpeg,png,jpg',
            'favicon_icon' => 'image|mimes:gif,png,jpg',
        ];
    }
}
