<?php

namespace Domain\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for the authenticated user in the global Inertia share.
 * Only exposes data needed for authentication and UI display.
 */
class AuthUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'locale' => $this->locale,
            'locale_type' => $this->locale_type,
            'company_id' => $this->company_id,
            'roles' => $this->roles->pluck('name'),
        ];
    }
}
