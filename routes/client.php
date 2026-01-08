<?php

use Domain\Company\Controllers\CompanyController;
use Domain\Quotation\Controllers\QuotationController;
use Domain\Company\Controllers\CompanyLocationController;
use Domain\Company\Controllers\UserController;
use Domain\Product\Controllers\ProductController;
use Domain\User\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('client.product.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('client.product.show');

    Route::get('/quotation', [QuotationController::class, 'create'])->name('quotation.create');
    Route::post('/quotation', [QuotationController::class, 'store'])->name('quotation.store');

    Route::get('/company', [CompanyController::class, 'show'])->name('client.company.show');
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('client.company.edit');
    Route::patch('/company', [CompanyController::class, 'update'])->name('client.company.update');

    Route::get('/quotations', [QuotationController::class, 'index'])->name('client.quotation.index');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('client.quotation.show');
    Route::delete('/quotations/{quotation}', [QuotationController::class, 'destroy'])->name('client.quotation.destroy');

    Route::get('/locations/create', [CompanyLocationController::class, 'create'])->name('client.location.create');
    Route::post('/locations', [CompanyLocationController::class, 'store'])->name('client.location.store');
    Route::get('/locations/{companyLocation}/edit', [CompanyLocationController::class, 'edit'])->name('client.location.edit');
    Route::patch('/locations/{companyLocation}', [CompanyLocationController::class, 'update'])->name('client.location.update');
    Route::delete('/locations/{companyLocation}', [CompanyLocationController::class, 'destroy'])->name('client.location.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('client.user.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('client.user.show');

});
