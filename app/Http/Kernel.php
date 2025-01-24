<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
     
    protected $routeMiddleware = [
        'can:admin-access' => \App\Http\Middleware\AdminMiddleware::class,

		
    ]; 
}
