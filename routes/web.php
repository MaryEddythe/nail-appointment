<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'services' => \App\Models\Service::all(),
    ]);
});

Route::get('/book', function () {
    return Inertia::render('Book', [
        'services' => \App\Models\Service::all(),
        'serviceId' => request('service'),
    ]);
});

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('Admin/Dashboard', [
            'appointments' => \App\Models\Appointment::with('service')->get(),
            'services' => \App\Models\Service::all(),
        ]);
    });
});