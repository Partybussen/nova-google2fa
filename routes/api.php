<?php

use Illuminate\Support\Facades\Route;

/**
 * This route is called when user must first time confirm secret
 */
Route::post('register', 'Project383\Google2fa\Google2fa@register');

/**
 * This route is called when user must first time confirm secret
 */
Route::post('confirm', 'Project383\Google2fa\Google2fa@confirm');

/**
 * This route is called to verify users secret
 */
Route::post('authenticate', 'Project383\Google2fa\Google2fa@authenticate');

Route::get('authenticate', [\Project383\Google2fa\Google2fa::class, 'showAuthenticate']);

//Route::get('recovery', [Project383\Google2fa\Google2fa::class, 'showRecovery']);