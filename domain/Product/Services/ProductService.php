<?php

namespace Domain\Product\Services;

use Domain\Helper\Enums\MediaCollectionType;
use Domain\Product\Models\Product;

class ProductService
{
    public static function update(Product $product, object $data): Product
    {
        $product->name = $data->name;
        $product->article_number = $data->article_number;
        $product->brand = $data->brand ?? null;
        $product->description = $data->description ?? null;
        $product->is_active = $data->is_active;

        $product->unit_price = $data->unit_price ?? 0;

        $product->supplier_id = $data->supplier_id;
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
