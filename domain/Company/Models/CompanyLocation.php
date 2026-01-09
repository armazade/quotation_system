<?php

namespace Domain\Company\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Domain\Company\Models\CompanyLocation
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $company_id
 * @property int $is_default
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property string $zip_code
 * @property string $city
 * @property string $country
 * @property-read Company $company
 * @method static Builder|CompanyLocation newModelQuery()
 * @method static Builder|CompanyLocation newQuery()
 * @method static Builder|CompanyLocation onlyTrashed()
 * @method static Builder|CompanyLocation query()
 * @method static Builder|CompanyLocation whereAddressLine1($value)
 * @method static Builder|CompanyLocation whereAddressLine2($value)
 * @method static Builder|CompanyLocation whereCity($value)
 * @method static Builder|CompanyLocation whereCompanyId($value)
 * @method static Builder|CompanyLocation whereCountry($value)
 * @method static Builder|CompanyLocation whereCreatedAt($value)
 * @method static Builder|CompanyLocation whereDeletedAt($value)
 * @method static Builder|CompanyLocation whereId($value)
 * @method static Builder|CompanyLocation whereIsDefault($value)
 * @method static Builder|CompanyLocation whereUpdatedAt($value)
 * @method static Builder|CompanyLocation whereZipCode($value)
 * @method static Builder|CompanyLocation withTrashed()
 * @method static Builder|CompanyLocation withoutTrashed()
 * @mixin Eloquent
 */
class CompanyLocation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'company_id',
        'is_default',
        'address_line_1',
        'address_line_2',
        'zip_code',
        'city',
        'country',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
