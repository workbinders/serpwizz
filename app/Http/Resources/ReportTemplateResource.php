<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->report->id,
            'report_header_text' => $this->report->report_header_text,
            'company_name' => $this->report->company_name,
            'company_email' => $this->report->company_email,
            'company_website' => $this->report->company_website,
            'company_phone' => $this->report->company_phone,
            'company_address' => $this->report->company_address,
            'company_logo' => $this->report->company_logo,
            'custom_title' => $this->report->custom_title,
            'custom_title_status' => $this->report->custom_title_status,
            'user_id' => $this->report->user_id,
            'created_at' => $this->report->created_at,
        ];
    }
}
