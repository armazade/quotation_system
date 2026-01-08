<?php

use Domain\User\Enums\PermissionType;
use Domain\User\Enums\RoleType;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $clientProductList = Permission::firstOrCreate(['name' => PermissionType::CLIENT_PRODUCT_LIST->value]);
        $clientProductRead = Permission::firstOrCreate(['name' => PermissionType::CLIENT_PRODUCT_READ->value]);

        $clientRole = Role::where('name', RoleType::CLIENT->value)->first();

        if ($clientRole) {
            $clientRole->givePermissionTo([$clientProductList, $clientProductRead]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $clientRole = Role::where('name', RoleType::CLIENT->value)->first();

        if ($clientRole) {
            $clientRole->revokePermissionTo([
                PermissionType::CLIENT_PRODUCT_LIST->value,
                PermissionType::CLIENT_PRODUCT_READ->value,
            ]);
        }

        Permission::where('name', PermissionType::CLIENT_PRODUCT_LIST->value)->delete();
        Permission::where('name', PermissionType::CLIENT_PRODUCT_READ->value)->delete();
    }
};
