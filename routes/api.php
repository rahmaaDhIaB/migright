<?php

use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\DemandController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Api\ServiceController as ApiServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PrivacyPolicyController;


Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{id}', [NewsController::class, 'getNewsById'])->where('id', '[0-9]+');
    Route::get('/popular', [NewsController::class, 'popularNews']);
});

Route::prefix('demands')->group(function () {
    Route::get('/', [DemandController::class, 'index']);
    Route::get('/{id}', [DemandController::class, 'getDemandById']);
    Route::post('/{id}/cancel', [DemandController::class, 'cancelDemandById'])->where('id', '[0-9]+');
    Route::prefix('testimonials')->group(function () {
        Route::post('/', [DemandController::class, 'submitTestimonial']);
        Route::get('/types', [DemandController::class, 'getTestimonialTypes']);
        Route::post('{id}', [DemandController::class, 'updateTestimonialDemand'])->where('id', '[0-9]+');
        Route::post('/cancel', [DemandController::class, 'cancelTestimonialDemand']);
    });
    Route::prefix('assistance')->group(function () {
        Route::post('/', [DemandController::class, 'submitAssistanceDemand']);
        Route::get('/types', [DemandController::class, 'getAssistanceTypes']);
        Route::post('{id}', [DemandController::class, 'updateAssistanceDemand'])->where('id', '[0-9]+');
        Route::post('/cancel', [DemandController::class, 'cancelAssistanceDemand']);
    });
    Route::prefix('lost-person')->group(function () {
        Route::post('/', [DemandController::class, 'submitLostPersonDemand']);
        Route::get('/types', [DemandController::class, 'getLostPersonTypes']);
        Route::post('{id}', [DemandController::class, 'updateLostPersonDemand'])->where('id', '[0-9]+');
        Route::post('/cancel', [DemandController::class, 'cancelLostPersonDemand']);
    });
});

Route::prefix('services')->group(function () {
    Route::get('/', [ApiServiceController::class, 'getServices']);
    Route::get('/{id}', [ApiServiceController::class, 'getServiceById']);
}) ;

Route::prefix('service-configurations')->group(function () {
    Route::get('/', [ConfigurationController::class, 'getConfigurations']);
});

Route::prefix('privacy-policy')->group(function () {
    Route::get('/', [PrivacyPolicyController::class, 'show']);
    Route::put('/{id}', [PrivacyPolicyController::class, 'update']);
});

Route::post('subscribe',[NotificationController::class,'subscribe']);
