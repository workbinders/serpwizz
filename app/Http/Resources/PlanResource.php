<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'monthly_price' => $this->monthly_price,
            'annual_price' => $this->annual_price,
            'description' => $this->description ?? NULL,
            'highlight' => $this->highlight,
            'features' => $this->features ?? [],
            'created_at' => $this->created_at,
        ];
    }
}
