<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BusinessAutopsyServiceProvider extends ServiceProvider
{
    /**
     * Register layanan modul Business Autopsy.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap layanan modul Business Autopsy.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/business_autopsy.php'));
        $this->loadRoutesFrom(base_path('routes/business_autopsy_admin.php'));
    }
}
