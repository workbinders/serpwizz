<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'company_name' => 'required',
            'company_address' => 'required',
            'company_website' => 'url',
            'company_phone' => 'integer|min:10',
            'custom_title_status' => 'boolean',
            'custom_title' => 'required_if:custom_title_status,1',
        ];
    }
}
