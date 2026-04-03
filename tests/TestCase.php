<?php

namespace Jmrashed\PurchaseKeyGuard\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Jmrashed\PurchaseKeyGuard\Providers\PurchaseKeyGuardServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [PurchaseKeyGuardServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Use in-memory SQLite for faster tests
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Set required env defaults
        $app['config']->set('purchase-key-guard.activation_limit', 2);
    }
}
