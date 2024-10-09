<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\Helpers;

class LeadListResource extends JsonResource
{
    use Helpers;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'website' => $this->website,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'custom_field' => $this->custom_field,
            'checkbox' => $this->checkbox,
            'score' => $this->score,
            'category' => $this->category,
            'language' => $this->language,
            'report_date' => $this->report_date,
            'date' => $this->dateFormat($this->created_at),
        ];
    }
}
