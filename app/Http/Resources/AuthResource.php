<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'slug'              => $this->slug,
            'email'             => $this->email,
            'role'              => $this->role,
            'profile_image'     => $this->profile_image,
            'language'          => $this->language,
            'referral_code'     => $this->referral_code,
            'account_name'      => $this->account_name,
            'last_login'        => $this->last_login,
            'last_login_ip'     => $this->last_login_ip,
            'last_login_client' => $this->last_login_client,
        ];
    }
}
