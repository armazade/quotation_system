<?php

namespace Domain\Quotation\Models;

use Database\Factories\QuotationFactory;
use Domain\Company\Models\Company;
use Domain\Quotation\Enums\QuotationDurationType;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Domain\Quotation\Models\Quotation
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $user_id
 * @property string $reference
 * @property QuotationStatusType $status
 * @property Carbon|null $quotation_sent_at
 * @property-read Company $company
 * @property-read mixed $expires_at
 * @property-read mixed $expires_in_days
 * @property-read Collection<int, QuotationLine> $lines
 * @property-read int|null $lines_count
 * @property-read mixed $total_price
 * @property-read User|null $user
 * @method static QuotationFactory factory($count = null, $state = [])
 * @method static Builder|Quotation newModelQuery()
 * @method static Builder|Quotation newQuery()
 * @method static Builder|Quotation onlyTrashed()
 * @method static Builder|Quotation query()
 * @method static Builder|Quotation whereCompanyId($value)
 * @method static Builder|Quotation whereCreatedAt($value)
 * @method static Builder|Quotation whereDeletedAt($value)
 * @method static Builder|Quotation whereId($value)
 * @method static Builder|Quotation whereQuotationSentAt($value)
 * @method static Builder|Quotation whereReference($value)
 * @method static Builder|Quotation whereStatus($value)
 * @method static Builder|Quotation whereUpdatedAt($value)
 * @method static Builder|Quotation whereUserId($value)
 * @method static Builder|Quotation withTrashed()
 * @method static Builder|Quotation withoutTrashed()
 * @mixin Eloquent
 */
class Quotation extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $appends = [
        'total_price',
        'expires_in_days',
        'expires_at',
    ];

    protected $casts = [
        'status' => QuotationStatusType::class,
        'quotation_sent_at' => 'date',
        'expires_at' => 'date',
    ];

    protected static function newFactory(): QuotationFactory
    {
        return QuotationFactory::new();
    }

    public function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->lines->sum('total_price'),
        );
    }

    public function lines(): HasMany
    {
        return $this->hasMany(QuotationLine::class, 'quotation_id', 'id');
    }

    public function expiresInDays(): Attribute
    {
        return Attribute::make(
            get: fn() => isset($this->quotation_sent_at) ? now()->diffInDays($this->expires_at, false) : null,
        );
    }

    public function expiresAt(): Attribute
    {
        return Attribute::make(
            get: fn() => isset($this->quotation_sent_at) ? $this->quotation_sent_at->addDays(QuotationDurationType::REGULAR->value) : null,
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
