# Purchase Key Guard

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jmrashed/purchase-key-guard.svg?style=flat-square)](https://packagist.org/packages/jmrashed/purchase-key-guard)
[![Total Downloads](https://img.shields.io/packagist/dt/jmrashed/purchase-key-guard.svg?style=flat-square)](https://packagist.org/packages/jmrashed/purchase-key-guard)

## Introduction

**Purchase Key Guard** is a Laravel package that helps protect your Laravel application from unauthorized use by validating a purchase key. It uses middleware to ensure that the application can only be used with a valid purchase key, making it a great solution for commercial or licensed applications.

## Features

- Middleware to validate purchase keys.
- API support for key validation.
- Easy-to-configure purchase key service.
- Customizable via configuration file.
- Integration with Laravel service providers and facades.
- Includes artisan commands for key management.

## Installation

You can install the package via Composer:

```bash
composer require jmrashed/purchase-key-guard
```

Once installed, publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Jmrashed\PurchaseKeyGuard\Providers\PurchaseKeyGuardServiceProvider" --tag="config"
```

This will create a `purchase_key.php` configuration file in your `config/` directory.

## Usage

After installation, the package adds middleware to validate the purchase key. Add the middleware to your `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // other middleware
        \Jmrashed\PurchaseKeyGuard\Http\Middleware\VerifyPurchaseKey::class,
    ],
];
```

You can also use the provided `PurchaseKeyService` to programmatically verify purchase keys.

## Configuration

You can modify the configuration by editing the `purchase_key.php` file. Here, you can set the default key, API settings, and more.

```php
return [
    'key' => env('PURCHASE_KEY', 'your-purchase-key-here'),
];
```

## Testing

To run the package tests, simply execute:

```bash
composer test
```

## License

The MIT License (MIT). Please see the [LICENSE](LICENSE) file for more details. 