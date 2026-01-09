<?php

namespace Domain\Company\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for the authenticated user's company in the global Inertia share.
 * Only exposes data needed for authentication and UI display.
 */
class AuthCompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_type' => $this->company_type,
            'is_schut' => $this->is_schut,
            'email' => $this->email,
            'credit_balance' => $this->credit_balance,
        ];
    }
}
