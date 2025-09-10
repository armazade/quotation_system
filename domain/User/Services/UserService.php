<?php

namespace Domain\User\Services;

use Domain\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public static function adminIndex(?string $fullName = null, ?string $email = null, ?string $companyName = null, ?int $perPage = 10): LengthAwarePaginator
    {
        $query = User::query()
            ->orderByDesc('created_at')
            ->with(['company']);

        if (isset($fullName)) {
            $query->where(function ($query) use ($fullName) {
                $query->where('first_name', 'like', '%' . $fullName . '%')
                    ->orWhere('last_name', 'like', '%' . $fullName . '%');
            });
        }

        if (isset($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if (isset($companyName)) {
            $query->whereHas('company', function ($query) use ($companyName) {
                $query->where('name', 'like', '%' . $companyName . '%');
            });
        }

        return $query->paginate($perPage)
            ->withQueryString();
    }

    public static function destroy(User $user): void
    {
        $user->delete();
    }
}
