<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\CompanyIndexRequest;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Services\CompanyService;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    public function index(CompanyIndexRequest $request): Response
    {
        $validated = (object)$request->validated();

        $companies = CompanyService::adminIndex(
            $validated->company_name ?? null,
            CompanyType::CLIENT
        );

        return Inertia::render('Admin/Client/Index', [
            'companies' => $companies,
        ]);
    }
}
