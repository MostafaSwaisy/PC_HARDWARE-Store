<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\SupplierController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    'auth:sanctum',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::prefix('api/v1')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('products', ProductController::class);
    });
});
