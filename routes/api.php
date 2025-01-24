<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\WebServiceController;

Route::get('/version-info', function () {
    $laravelVersion = Application::VERSION;
    $phpVersion = PHP_VERSION;

    return response()->json([
        'Laravel Version' => $laravelVersion,
        'PHP Version' => $phpVersion,
    ]);
});

Route::any('/test', [WebServiceController::class, 'test']);
Route::any('/projects', [WebServiceController::class, 'getProjects']);
