<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\AuthorInterface::class, \App\Repositories\AuthorRepository::class);
        $this->app->bind(\App\Interfaces\VirusInterface::class, \App\Repositories\VirusRepository::class);
        $this->app->bind(\App\Interfaces\GenotipeInterface::class, \App\Repositories\GenotipeRepository::class);
        $this->app->bind(\App\Interfaces\TransmissionInterface::class, \App\Repositories\TransmissionRepository::class);
        $this->app->bind(\App\Interfaces\SampleInterface::class, \App\Repositories\SampleRepository::class);
        $this->app->bind(\App\Interfaces\HivCaseInterface::class, \App\Repositories\HivCaseRepository::class);
        $this->app->bind(\App\Interfaces\CitationInterface::class, \App\Repositories\CitationRepository::class);
        $this->app->bind(\App\Interfaces\FrontendInterface::class, \App\Repositories\FrontendRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
