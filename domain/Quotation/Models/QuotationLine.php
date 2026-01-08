<?php

namespace Domain\Quotation\Models;

use Domain\Product\Models\Product;
use Domain\Quotation\Enums\QuotationLineType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    use SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'description',
        'has_custom_description',
        'quantity',
        'unit_price',
        'line_type',
    ];

    protected $appends = ['total_price'];

    protected $casts = [
        'unit_price' => 'float',
        'quantity' => 'integer',
        'has_custom_description' => 'boolean',
        'line_type' => QuotationLineType::class,
    ];

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->quantity * $this->unit_price,
        );
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class, 'quotation_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
