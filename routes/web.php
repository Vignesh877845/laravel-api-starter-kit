<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'application' => 'Laravel API Starter Kit',
        'version'     => '1.0.0',
        'environment' => app()->environment(),
        'status'      => 'ok',
        'documentation' => url('/docs/api'),
        'author'      => 'Vignesh V'
    ]);
});
