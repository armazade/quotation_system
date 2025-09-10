<?php

namespace Domain\Product\Services;

use Domain\Product\Enums\ProcessingTermType;
use Domain\Product\Models\Product;
use Domain\Product\Models\ProductDeliveryOption;

class ProductDeliveryOptionService
{
    public static function update(Product $product, ProcessingTermType $type, ?int $days): void
    {
        $deliveryOption = ProductDeliveryOption::query()
            ->where('product_id', $product->id)
            ->where('processing_term_type', $type)
            ->first();

        if (!isset($days)) {
            $deliveryOption?->delete();
            return;
        }

        if (!$deliveryOption) {
            $deliveryOption = new ProductDeliveryOption();
            $deliveryOption->product_id = $product->id;
            $deliveryOption->processing_term_type = $type;
        }

        $deliveryOption->days = $days;
        $deliveryOption->save();
    }
}
