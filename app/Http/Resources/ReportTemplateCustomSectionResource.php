<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportTemplateCustomSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'section_name' => $this->section_name ?? null,
            'position' => $this->position,
            'user_id' => $this->user_id,
            'text' => $this->text,
            'script_code' => $this->script_code,
            'created_at' => $this->created_at,
        ];
    }
}
