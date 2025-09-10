<?php

namespace Domain\Product\Services;

use Domain\Helper\Enums\MediaCollectionType;
use Domain\Product\Models\Product;

class ProductService
{
    public static function update(Product $product, object $data): Product
    {
        $product->name = $data->name;
        $product->description = $data->description ?? null;
        $product->info_link = $data->info_link ?? null;
        $product->is_active = $data->is_active;

        $product->unit_price = $data->unit_price ?? 0;
        $product->min_order_quantity = $data->min_order_quantity ?? 0;

        $product->supplier_id = $data->supplier_id;
        $product->notify_supplier = $data->notify_supplier;
        $product->save();

        if (isset($data->file)) {
            $product->clearMediaCollection(MediaCollectionType::PROFILE_IMAGES->value);

            $file = $data->file;
            $fileName = strtolower($product->id) . '_image.' . $file->extension();

            $product->addMedia($file)
                ->usingFileName($fileName)
                ->toMediaCollection(MediaCollectionType::PROFILE_IMAGES->value);
        }

        return $product;
    }
}
