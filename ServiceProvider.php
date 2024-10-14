<?php

namespace Jmrashed\PurchaseKeyGuard\Providers;

use Illuminate\Support\ServiceProvider;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
use Jmrashed\PurchaseKeyGuard\Http\Middleware\VerifyPurchaseKey;

class PurchaseKeyGuardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the package's configuration file
        $this->publishes([
            __DIR__ . '/../../config/purchase_key.php' => config_path('purchase_key.php'),
        ], 'config');

        // Load the package's migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Load the package's routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        // Register the package's views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'purchase-key-guard');

        // Register middleware for global or route-specific use
        $this->app['router']->aliasMiddleware('verifyPurchaseKey', VerifyPurchaseKey::class);

        // Register any package-specific events here
        $this->app['events']->listen('purchase.key.validated', function ($event) {
            // Handle the event (e.g., logging or notifications)
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the PurchaseKeyService to the service container
        $this->app->singleton(PurchaseKeyService::class, function ($app) {
            return new PurchaseKeyService();
        });

        // Alias for easier access
        $this->app->alias(PurchaseKeyService::class, 'purchase-key');

        // Merge package config with the application's config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/purchase_key.php', 'purchase_key'
        );
    }
}
