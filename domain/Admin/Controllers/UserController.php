<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\SuperAdminRequest;
use Domain\Admin\Requests\UserIndexRequest;
use Domain\User\Models\User;
use Domain\User\Resources\UserResource;
use Domain\User\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(UserIndexRequest $request): Response
    {
        $validated = (object) $request->validated();

        $users = UserService::adminIndex(
            $validated->full_name ?? null,
            $validated->email ?? null,
            $validated->company_name ?? null,
        );

        return Inertia::render('Admin/User/Index', [
            'users' => UserResource::collection($users)->response()->getData(true),
        ]);
    }

    public function show(SuperAdminRequest $request, User $user): Response
    {
        $user->load('company');

        return Inertia::render('Admin/User/Show', [
            'user' => new UserResource($user),
        ]);
    }
}
