<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhiteLabelSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whiteLabelSettings->id,
            'white_label' => $this->whiteLabelSettings->white_label,
            'domain_name' => $this->whiteLabelSettings->domain_name,
            'audit_report_title' => $this->whiteLabelSettings->audit_report_title,
            'header_big_logo' => $this->whiteLabelSettings->header_big_logo,
            'header_small_logo' => $this->whiteLabelSettings->header_small_logo,
            'favicon_icon' => $this->whiteLabelSettings->favicon_icon,
            'user_id' => $this->whiteLabelSettings->user_id,
            'created_at' => $this->created_at,
        ];
    }
}
