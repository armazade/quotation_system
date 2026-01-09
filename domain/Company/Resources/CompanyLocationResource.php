<?php

namespace Domain\Company\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for company location data.
 */
class CompanyLocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_default' => $this->is_default,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
