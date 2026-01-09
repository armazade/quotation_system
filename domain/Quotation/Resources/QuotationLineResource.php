<?php

namespace Domain\Quotation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for quotation line data.
 */
class QuotationLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'has_custom_description' => $this->has_custom_description,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'line_type' => $this->line_type,
            'product_id' => $this->product_id,
        ];
    }
}
