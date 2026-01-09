<?php

namespace Domain\Company\Resources;

use Domain\Quotation\Resources\QuotationResource;
use Domain\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for company data in admin views.
 * Does not expose encrypted financial data (iban, bic, vat, coc).
 */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_type' => $this->company_type,
            'is_schut' => $this->is_schut,
            'debiteur_number' => $this->debiteur_number,
            'email' => $this->email,
            'phone_country_code' => $this->phone_country_code,
            'phone_number' => $this->phone_number,
            'full_phone_number' => $this->full_phone_number,
            'website' => $this->website,
            'legal_owner' => $this->legal_owner,
            'industry_type' => $this->industry_type,
            'exact_id' => $this->exact_id,
            'credit_balance' => $this->credit_balance,
            'created_at' => $this->created_at?->toISOString(),
            'locations' => $this->whenLoaded('locations', fn () => CompanyLocationResource::collection($this->locations)->resolve()),
            'quotations' => $this->whenLoaded('quotations', fn () => QuotationResource::collection($this->quotations)->resolve()),
            'users' => $this->whenLoaded('users', fn () => UserResource::collection($this->users)->resolve()),
            'default_location' => $this->whenLoaded('defaultLocation', fn () => (new CompanyLocationResource($this->defaultLocation))->resolve()),
        ];
    }
}
