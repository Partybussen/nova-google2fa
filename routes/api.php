<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('nova.api_middleware')], function() {
    Route::post('register', [Project383\Google2fa\Google2fa::class, 'register']);

    Route::post('confirm', [Project383\Google2fa\Google2fa::class, 'confirmRegistration']);

    Route::post('authenticate', [Project383\Google2fa\Google2fa::class, 'authenticate']);

    Route::post('recover', [Project383\Google2fa\Google2fa::class, 'checkRecovery']);

    Route::get('authenticate', [\Project383\Google2fa\Google2fa::class, 'showAuthenticate']);

    Route::get('recover', [\Project383\Google2fa\Google2fa::class, 'showRecovery']);

    Route::get('register', [Project383\Google2fa\Google2fa::class, 'showRegister']);
});