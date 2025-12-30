<?php

namespace EveTools\ApplicantIntelligence;

use Illuminate\Support\ServiceProvider;

class ApplicantIntelligenceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'applicant-intelligence');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
