<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\SuperAdminRequest;
use Domain\Admin\Requests\UserIndexRequest;
use Domain\User\Models\User;
use Domain\User\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(UserIndexRequest $request): Response
    {
        $validated = (object)$request->validated();

        $users = UserService::adminIndex(
            $validated->full_name ?? null,
            $validated->email ?? null,
            $validated->company_name ?? null,
        );

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
        ]);
    }

    public function show(SuperAdminRequest $request, User $user): Response
    {
        return Inertia::render('Admin/User/Show', [
            'user' => $user,
        ]);
    }
}
