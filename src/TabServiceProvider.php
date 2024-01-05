<?php

namespace Fintech\Tab;

use Illuminate\Support\ServiceProvider;
use Fintech\Tab\Commands\InstallCommand;
use Fintech\Tab\Commands\TabCommand;

class TabServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/tab.php', 'fintech.tab'
        );

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/tab.php' => config_path('fintech/tab.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'tab');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/tab'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tab');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tab'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                TabCommand::class,
            ]);
        }
    }
}
