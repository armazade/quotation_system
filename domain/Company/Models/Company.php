<?php

namespace Domain\Company\Models;

use Database\Factories\CompanyFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\IndustryType;
use Domain\Product\Models\Product;
use Domain\Quotation\Models\Quotation;
use Domain\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/**
 * Domain\Company\Models\Company
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property CompanyType $company_type
 * @property bool $is_schut
 * @property string $name
 * @property string|null $debiteur_number
 * @property string|null $email
 * @property CountryCodeType|null $phone_country_code
 * @property string|null $phone_number
 * @property string|null $website
 * @property string|null $legal_owner
 * @property string|null $vat_number
 * @property string|null $coc_number
 * @property string|null $iban_number
 * @property string|null $bic_number
 * @property string|null $vat_number_validated_at
 * @property IndustryType|null $industry_type
 * @property string|null $exact_id
 * @property int $credit_balance
 * @property-read int|null $comments_count
 * @property-read int|null $credit_transactions_count
 * @property-read CompanyLocation|null $defaultLocation
 * @property-read mixed $full_phone_number
 * @property-read Collection<int, CompanyLocation> $locations
 * @property-read int|null $locations_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $orders_count
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read Collection<int, Quotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static CompanyFactory factory($count = null, $state = [])
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company onlyTrashed()
 * @method static Builder|Company query()
 * @method static Builder|Company whereBicNumber($value)
 * @method static Builder|Company whereCocNumber($value)
 * @method static Builder|Company whereCompanyType($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereCreditBalance($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company whereEmail($value)
 * @method static Builder|Company whereExactId($value)
 * @method static Builder|Company whereIbanNumber($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereIndustryType($value)
 * @method static Builder|Company whereLegalOwner($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company wherePhoneCountryCode($value)
 * @method static Builder|Company wherePhoneNumber($value)
 * @method static Builder|Company whereSubscriptionType($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereVatNumber($value)
 * @method static Builder|Company whereVatNumberValidatedAt($value)
 * @method static Builder|Company whereWebsite($value)
 * @method static Builder|Company withTrashed()
 * @method static Builder|Company withoutTrashed()
 *
 * @mixin Eloquent
 */
class Company extends Model
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $fillable = [
        'company_type',
        'is_schut',
        'name',
        'debiteur_number',
        'email',
        'phone_country_code',
        'phone_number',
        'website',
        'legal_owner',
        'vat_number',
        'coc_number',
        'iban_number',
        'bic_number',
        'industry_type',
        'exact_id',
        'credit_balance',
    ];

    protected $casts = [
        'phone_country_code' => CountryCodeType::class,
        'company_type' => CompanyType::class,
        'industry_type' => IndustryType::class,
        'is_schut' => 'boolean',
    ];

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }

    public function locations(): HasMany
    {
        return $this->hasMany(CompanyLocation::class, 'company_id', 'id')->orderBy('is_default')->orderByDesc('created_at');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id', 'id')->orderByDesc('created_at');
    }

    public function defaultLocation(): HasOne
    {
        return $this->hasOne(CompanyLocation::class, 'company_id', 'id')->where('is_default', 1);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'company_id', 'id')->orderByDesc('created_at');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id', 'id')->orderByDesc('created_at');
    }

    public function fullPhoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->phone_country_code->value.$this->phone_number,
        );
    }

    public function notifyUsers(Notification $notification): void
    {
        foreach ($this->users as $user) {
            $user->notify($notification);
        }
    }
}
