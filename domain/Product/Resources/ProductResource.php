<?php

namespace Domain\Product\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource for product data.
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'unit_price' => $this->unit_price,
            'description' => $this->description,
            'article_number' => $this->article_number,
            'brand' => $this->brand,
            'delivery_time' => $this->delivery_time,
            'created_at' => $this->created_at?->toISOString(),
            'supplier_id' => $this->supplier_id,
            'supplier' => $this->whenLoaded('supplier', fn () => [
                'id' => $this->supplier->id,
                'name' => $this->supplier->name,
            ]),
            'profile_images' => $this->whenLoaded('profileImages', fn () => $this->profileImages->map(fn ($media) => [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'name' => $media->name,
            ])),
            'delivery_options' => $this->whenLoaded('deliveryOptions', fn () => $this->deliveryOptions->map(fn ($option) => [
                'id' => $option->id,
                'processing_term_type' => $option->processing_term_type,
                'days' => $option->days,
            ])),
        ];
    }
}
