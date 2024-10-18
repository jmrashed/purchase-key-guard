<?php

namespace Jmrashed\PurchaseKeyGuard\Providers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\ServiceProvider;
use Jmrashed\PurchaseKeyGuard\Services\PurchaseKeyService;
use Jmrashed\PurchaseKeyGuard\Http\Middleware\VerifyPurchaseKey;
use Jmrashed\PurchaseKeyGuard\Models\PurchaseKey;
use Jmrashed\PurchaseKeyGuard\Services\EnvatoService;

class PurchaseKeyGuardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Toastr::useVite();


        $this->publishes([
            __DIR__ . '/../../resources/css' => public_path('vendor/purchase-key-guard/css'),
            __DIR__ . '/../../resources/js' => public_path('vendor/purchase-key-guard/js'),
            __DIR__ . '/../../config/purchase-key-guard.php' => config_path('purchase-key-guard.php'),
        ], 'public');

        // Load the package's migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Load the package's routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

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
            return new PurchaseKeyService(
                $app->make(PurchaseKey::class),
                $app->make(EnvatoService::class)
            );
        });

        // Alias for easier access
        $this->app->alias(PurchaseKeyService::class, 'purchase-key');
    }
}
