<?php

namespace Fintech\Tab\Seeders\Bangladesh;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ServiceVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('tab:sslwireless-setup');
    }
}
