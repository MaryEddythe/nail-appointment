<?php

namespace App\Http;

class Kernel
{
    protected $routeMiddleware = [
        
        // ...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

    protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class,
    // ... other middleware
];

protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\HandleInertiaRequests::class,
    ],
];
}