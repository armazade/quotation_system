<?php

namespace Domain\Product\Models;

use Domain\Product\Enums\ProcessingTermType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Domain\Product\Models\ProductDeliveryOption
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $product_id
 * @property ProcessingTermType $processing_term_type
 * @property int $days
 * @property-read Product $product
 * @method static Builder|ProductDeliveryOption newModelQuery()
 * @method static Builder|ProductDeliveryOption newQuery()
 * @method static Builder|ProductDeliveryOption query()
 * @method static Builder|ProductDeliveryOption whereCreatedAt($value)
 * @method static Builder|ProductDeliveryOption whereDays($value)
 * @method static Builder|ProductDeliveryOption whereId($value)
 * @method static Builder|ProductDeliveryOption whereProcessingTermType($value)
 * @method static Builder|ProductDeliveryOption whereProductId($value)
 * @method static Builder|ProductDeliveryOption whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductDeliveryOption extends Model
{
    use HasUuids;

    protected $casts = [
        'processing_term_type' => ProcessingTermType::class,
    ];

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class, 'product_id', 'id');
    }
}
