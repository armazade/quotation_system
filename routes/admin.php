<?php

use Domain\Admin\Controllers\ClientController;
use Domain\Admin\Controllers\CompanyController;
use Domain\Admin\Controllers\DashboardController;
use Domain\Admin\Controllers\QuotationController;
use Domain\Admin\Controllers\UserController;
use Domain\Company\Controllers\CompanyLocationController;
use Domain\Product\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->prefix('/admin')->group(callback: function () {
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.user.show');

    Route::get('/clients', [ClientController::class, 'index'])->name('admin.client.index');

    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('admin.company.show');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('admin.company.edit');
    Route::patch('/companies/{company}', [CompanyController::class, 'update'])->name('admin.company.update');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('admin.company.destroy');

    Route::get('/locations/{company}/create', [CompanyLocationController::class, 'create'])->name('admin.location.create');
    Route::post('/locations/{company}', [CompanyLocationController::class, 'store'])->name('admin.location.store');
    Route::get('/locations/{companyLocation}/edit', [CompanyLocationController::class, 'edit'])->name('admin.location.edit');
    Route::patch('/locations/{companyLocation}', [CompanyLocationController::class, 'update'])->name('admin.location.update');
    Route::delete('/locations/{companyLocation}', [CompanyLocationController::class, 'destroy'])->name('admin.location.destroy');

    Route::get('/quotations', [QuotationController::class, 'index'])->name('admin.quotation.index');
    Route::get('/quotations/create', [QuotationController::class, 'create'])->name('admin.quotation.create');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('admin.quotation.store');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('admin.quotation.show');
    Route::get('/quotations/{quotation}/edit', [QuotationController::class, 'edit'])->name('admin.quotation.edit');
    Route::patch('/quotations/{quotation}', [QuotationController::class, 'update'])->name('admin.quotation.update');
    Route::delete('/quotations/{quotation}', [QuotationController::class, 'destroy'])->name('admin.quotation.destroy');

    Route::post('/quotations/{quotation}/send', [QuotationController::class, 'send'])->name('admin.quotation.send');
    Route::post('/quotations/{quotation}/approve', [QuotationController::class, 'approve'])->name('admin.quotation.approve');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/product', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::patch('/product/{product}', [ProductController::class, 'update'])->name('admin.product.update');
});
