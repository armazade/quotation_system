<?php

namespace App\Http\Middleware;

use Domain\Company\Resources\AuthCompanyResource;
use Domain\User\Resources\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => fn () => $this->getAuthData(),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'locale' => fn () => App::getLocale(),
        ]);
    }

    /**
     * Get authentication data including permissions.
     */
    protected function getAuthData(): array
    {
        $user = Auth::user();

        if (! $user) {
            return [
                'user' => null,
                'company' => null,
                'permissions' => [],
            ];
        }

        // Load roles with permissions
        $user->load(['roles.permissions', 'company']);

        // Collect all permissions from all roles
        $permissions = $user->roles
            ->flatMap(fn ($role) => $role->permissions->pluck('name'))
            ->unique()
            ->values()
            ->toArray();

        return [
            'user' => (new AuthUserResource($user))->resolve(),
            'company' => $user->company ? (new AuthCompanyResource($user->company))->resolve() : null,
            'permissions' => $permissions,
        ];
    }
}
