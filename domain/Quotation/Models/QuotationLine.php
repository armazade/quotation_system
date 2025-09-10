<?php

namespace Domain\Quotation\Models;

use Domain\Product\Models\Product;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;


/**
 * Domain\Quotation\Models\QuotationLine
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $quotation_id
 * @property string $description
 * @property int $has_custom_description
 * @property string $quantity
 * @property float $unit_price
 * @property-read Quotation|null $quotation
 * @property-read mixed $total_price
 * @method static Builder|QuotationLine newModelQuery()
 * @method static Builder|QuotationLine newQuery()
 * @method static Builder|QuotationLine query()
 * @method static Builder|QuotationLine whereCreatedAt($value)
 * @method static Builder|QuotationLine whereDeletedAt($value)
 * @method static Builder|QuotationLine whereDescription($value)
 * @method static Builder|QuotationLine whereHasCustomDescription($value)
 * @method static Builder|QuotationLine whereId($value)
 * @method static Builder|QuotationLine whereLineType($value)
 * @method static Builder|QuotationLine whereQuantity($value)
 * @method static Builder|QuotationLine whereQuotationId($value)
 * @method static Builder|QuotationLine whereUnitPrice($value)
 * @method static Builder|QuotationLine whereUpdatedAt($value)
 * @mixin Eloquent
 */
class QuotationLine extends Model
{
    use HasUuids;

    protected $appends = ['total_price'];

    protected $casts = [
        'unit_price' => 'float',
    ];

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quantity * $this->unit_price,
        );
    }

    public function quotation(): HasOne
    {
        return $this->hasOne(Quotation::class, 'id', 'quotation_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
