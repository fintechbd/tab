<?php

namespace Fintech\Tab;

use Fintech\Core\Traits\Packages\RegisterPackageTrait;
use Fintech\Tab\Commands\InstallCommand;
use Fintech\Tab\Commands\SSLWirelessSetupCommand;
use Fintech\Tab\Providers\RepositoryServiceProvider;
use Illuminate\Support\ServiceProvider;

class TabServiceProvider extends ServiceProvider
{
    use RegisterPackageTrait;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->packageCode = 'tab';

        $this->mergeConfigFrom(
            __DIR__.'/../config/tab.php', 'fintech.tab'
        );

        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->injectOnConfig();

        $this->publishes([
            __DIR__.'/../config/tab.php' => config_path('fintech/tab.php'),
        ], 'fintech-tab-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'tab');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/tab'),
        ], 'fintech-tab-lang');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tab');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/tab'),
        ], 'fintech-tab-views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                SSLWirelessSetupCommand::class,
            ]);
        }
    }
}
