<?php

namespace Domain\User\Models;

use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Domain\Helper\Enums\LocaleType;
use Domain\Quotation\Models\Quotation;
use Domain\User\Enums\PermissionType;
use Domain\User\Enums\RoleType;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * Domain\User\Models\User
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property Carbon|null $email_verified_at
 * @property string|null $terms_accepted_at
 * @property LocaleType $locale_type
 * @property string|null $remember_token
 * @property string|null $company_id
 * @property-read Company|null $company
 * @property-read mixed $full_name
 * @property-read mixed $locale
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Quotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLocaleType($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTermsAcceptedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasUuids;
    use HasRoles;

    protected $with = [
        'roles',
        'roles.permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'locale_type' => LocaleType::class,
    ];

    protected $appends = [
        'full_name',
        'locale',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function hasLoadedPermission(PermissionType $permissionType): bool
    {
        foreach ($this->getLoadedPermissions() as $permission) {
            if ($permission == $permissionType->value) {
                return true;
            }
        }

        return false;
    }

    public function getLoadedPermissions(): Collection
    {
        $col = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $col[] = $permission->name;
            }
        }

        return collect($col);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'company_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function attachCompany(Company $company, ?bool $isSuperUser = false, ?bool $isAdmin = false): void
    {
        if ($this->company_id) {
            return;
        }

        $this->company_id = $company->id;
        $this->save();

        $roles = [];
        if ($company->company_type === CompanyType::CLIENT) {
            $roles[] = RoleType::CLIENT->value;
        }

        if ($isAdmin) {
            $roles[] = RoleType::ADMIN->value;

            if ($isSuperUser) {
                $roles[] = RoleType::SUPER_ADMIN->value;
            }
        }

        $this->assignRole($roles);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole([RoleType::ADMIN->value]);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole([RoleType::SUPER_ADMIN->value]);
    }

    public function preferredLocale(): string
    {
        return $this->locale;
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->first_name . ' ' . $this->last_name,
        );
    }

    protected function locale(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->locale_type->value,
        );
    }
}
