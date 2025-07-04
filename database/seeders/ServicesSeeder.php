<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'name' => 'Basic Manicure',
            'description' => 'Basic nail care with polish',
            'duration' => 30,
            'price' => 25.00,
        ]);
        
        Service::create([
            'name' => 'Gel Manicure',
            'description' => 'Long-lasting gel polish application',
            'duration' => 45,
            'price' => 40.00,
        ]);
        
        Service::create([
            'name' => 'Acrylic Full Set',
            'description' => 'Full set of acrylic nails',
            'duration' => 90,
            'price' => 60.00,
        ]);
    }
}