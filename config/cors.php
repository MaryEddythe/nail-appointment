<?php

return [
    'paths' => [
        'api/*', 
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'admin/*'  // Add any admin routes
    ],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowed_origins' => [
        'https://nail-appointment.onrender.com',
        'http://localhost:3000'  // For local development
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'Authorization',
        'X-Requested-With',
        'X-Inertia'
    ],

    'exposed_headers' => [
        'X-Inertia'
    ],

    'max_age' => 86400,  // 24 hours cache for preflight requests

    'supports_credentials' => true,  // Enable if using cookies/sessions
];