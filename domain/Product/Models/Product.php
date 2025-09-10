<?php

namespace Domain\Product\Models;

use Domain\Company\Models\Company;
use Domain\Helper\Enums\MediaCollectionType;
use Domain\Product\Enums\ProcessingTermType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Domain\Product\Models\Product
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property bool $is_active
 * @property int $min_order_quantity
 * @property string $supplier_id
 * @property bool $notify_supplier
 * @property float $unit_price
 * @property string|null $description
 * @property string|null $info_link
 * @property-read Collection<int, ProductDeliveryOption> $deliveryOptions
 * @property-read int|null $delivery_options_count
 * @property-read mixed $delivery_time
 * @property-read mixed $delivery_time_express
 * @property-read mixed $delivery_time_subscription1
 * @property-read mixed $delivery_time_subscription2
 * @property-read mixed $delivery_time_subscription3
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read MediaCollection<int, Media> $profileImages
 * @property-read int|null $profile_images_count
 * @property-read Company $supplier
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereInfoLink($value)
 * @method static Builder|Product whereIsActive($value)
 * @method static Builder|Product whereMinOrderQuantity($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereNotifySupplier($value)
 * @method static Builder|Product whereSupplierId($value)
 * @method static Builder|Product whereUnitPrice($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;

    protected $with = [
        'deliveryOptions',
        'profileImages',
    ];

    protected $appends = [
        'delivery_time',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'notify_supplier' => 'boolean',
        'unit_price' => 'float',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }

    public function deliveryTime(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getDeliveryOption(ProcessingTermType::REGULAR),
        );
    }

    public function getDeliveryOption(ProcessingTermType $deliveryType): ?int
    {
        return $this->deliveryOptions->where('processing_term_type', $deliveryType)->first()?->days ?? null;
    }

    public function deliveryOptions(): HasMany
    {
        return $this->hasMany(ProductDeliveryOption::class, 'product_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionType::PROFILE_IMAGES->value)->singleFile();
    }

    public function profileImages(): MorphMany
    {
        return $this->media()->where('collection_name', MediaCollectionType::PROFILE_IMAGES->value);
    }
}
