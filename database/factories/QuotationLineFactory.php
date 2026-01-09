<?php

namespace Database\Factories;

use Domain\Product\Models\Product;
use Domain\Quotation\Enums\QuotationLineType;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Models\QuotationLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationLineFactory extends Factory
{
    protected $model = QuotationLine::class;

    public function definition(): array
    {
        $product = Product::where('is_active', true)->inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 10);

        return [
            'product_id' => $product?->id,
            'description' => $product?->name ?? fake()->words(3, true),
            'has_custom_description' => false,
            'quantity' => $quantity,
            'unit_price' => $product?->unit_price ?? fake()->randomFloat(2, 50, 500),
            'line_type' => QuotationLineType::PRODUCT,
        ];
    }

    public function forQuotation(Quotation $quotation): static
    {
        return $this->state([
            'quotation_id' => $quotation->id,
        ]);
    }

    public function withProduct(Product $product): static
    {
        return $this->state([
            'product_id' => $product->id,
            'description' => $product->name,
            'unit_price' => $product->unit_price,
        ]);
    }

    public function customDescription(string $description): static
    {
        return $this->state([
            'description' => $description,
            'has_custom_description' => true,
        ]);
    }

    public function delivery(): static
    {
        return $this->state([
            'product_id' => null,
            'description' => 'Delivery costs',
            'has_custom_description' => true,
            'quantity' => 1,
            'unit_price' => 9.00,
            'line_type' => QuotationLineType::DELIVERY,
        ]);
    }
}
