<?php

namespace Domain\Product\Gates;

use Domain\Product\Models\Product;
use Domain\User\Gates\UserGate;
use Domain\User\Models\User;

class ProductGate
{
    public static function index(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return UserGate::existsWithCompany($user);
    }

    public static function show(?User $user, ?Product $product): bool
    {
        if (! $user || ! $product) {
            return false;
        }

        return UserGate::existsWithCompany($user);
    }

    public static function create(?User $user): bool
    {
        return UserGate::isAdmin($user);
    }

    public static function update(?User $user, ?Product $product): bool
    {
        if (! $product) {
            return false;
        }

        return UserGate::isAdmin($user);
    }

    public static function destroy(?User $user, ?Product $product): bool
    {
        if (! $product) {
            return false;
        }

        return UserGate::isAdmin($user);
    }
}
