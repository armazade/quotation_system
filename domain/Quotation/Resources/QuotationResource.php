<?php

namespace Domain\Quotation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for quotation data.
 */
class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reference' => $this->reference,
            'quotation_sent_at' => $this->quotation_sent_at?->toISOString(),
            'expires_at' => $this->expires_at?->toISOString(),
            'expires_in_days' => $this->expires_in_days,
            'total_price' => $this->total_price,
            'subtotal' => $this->subtotal,
            'delivery_cost' => $this->delivery_cost,
            'grand_total' => $this->grand_total,
            'created_at' => $this->created_at?->toISOString(),
            'company_id' => $this->company_id,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'full_name' => $this->user->full_name,
                'email' => $this->user->email,
            ]),
            'lines' => QuotationLineResource::collection($this->whenLoaded('lines')),
        ];
    }
}
