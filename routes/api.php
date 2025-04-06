<?php

use App\Http\Controllers\AcquisitionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        dd("ADRES API (V1)");
    });

    Route::get('/acquisitions', [AcquisitionController::class, "index"]);
    Route::post('/acquisitions', [AcquisitionController::class, "store"]);
    Route::get('/acquisitions/{acquisition}', [AcquisitionController::class, "show"]);
    Route::put('/acquisitions/{acquisition}', [AcquisitionController::class, "update"]);
    Route::post('/change-status/{acquisition}', [AcquisitionController::class,"changeStatus"]);
    Route::get('/get-suppliers', [AcquisitionController::class,"getSuppliers"]);
});