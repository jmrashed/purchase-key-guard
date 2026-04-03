# Purchase Key Guard

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jmrashed/purchase-key-guard.svg?style=flat-square)](https://packagist.org/packages/jmrashed/purchase-key-guard)
[![Latest Version](https://img.shields.io/github/v/tag/jmrashed/purchase-key-guard.svg?style=flat-square)](https://github.com/jmrashed/purchase-key-guard/tags)
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
- Duplicate purchase code prevention.
- Configurable API URL for external revalidation.
- Comprehensive unit tests.

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



After publishing the configuration file, you can find it at `config/purchase-key-guard.php`. This file allows you to configure the settings for the purchase key validation.



### Authentication



The `authentication` array allows you to configure multiple vendor accounts for Envato API validation. You can add as many accounts as you need.



```php

'authentication' => [

    [

        'vendor' => env('PURCHASE_KEY_VENDOR_ACCOUNT1', 'Account 1'),

        'token' => env('PURCHASE_KEY_TOKEN_ACCOUNT1', ''),

        'item_id' => env('PURCHASE_KEY_ITEM_ID_ACCOUNT1', ''),

        'status' => env('PURCHASE_KEY_STATUS_ACCOUNT1', false),

    ],

    // ...

],

```



- `vendor`: A friendly name for the vendor account.

- `token`: Your Envato API personal token.

- `item_id`: The ID of the item on Envato Market.

- `status`: Whether this vendor account is active or not.


### API URL

The `api_url` setting defines the base URL for external code revalidation endpoints used by `PurchaseKeyService`.

```php

'api_url' => env('PURCHASE_KEY_GUARD_API_URL', 'https://api.your-service.com'),

```


### Activation Limit



The `activation_limit` setting determines how many times a purchase key can be activated on different domains.



```php

'activation_limit' => env('PURCHASE_KEY_ACTIVATION_LIMIT', 1),

```



## Admin Interface



The package includes a simple admin interface to manage purchase keys. You can access it at `/admin/purchase-keys`.



The admin interface allows you to:

- View all purchase keys.

- Create new purchase keys.

- Edit existing purchase keys.

- Delete purchase keys.

- Revoke purchase keys.



## Artisan Commands



The package includes an Artisan command to check for expired keys.



### `purchase-key:check-expired`



This command will check for purchase keys that have expired and update their status to `expired`.



You can run it manually:

```bash

php artisan purchase-key:check-expired

```



Or schedule it to run periodically in your `app/Console/Kernel.php` file:



```php

protected function schedule(Schedule $schedule)

{

    $schedule->command('purchase-key:check-expired')->daily();

}

```



## Events



The package fires an event when a purchase key is validated: `purchase.key.validated`.



You can listen for this event in your `EventServiceProvider`:



```php

protected $listen = [

    'purchase.key.validated' => [

        // Your listeners here

    ],

];

```



## Extending the Package



You can extend the package by:

- Creating your own views and publishing them.

- Creating your own validation logic by extending the `PurchaseKeyService`.

- Creating your own controllers and routes to customize the behavior of the package.

## Testing

To run the package tests, simply execute:

```bash
composer test
```

## License

The MIT License (MIT). Please see the [LICENSE](LICENSE) file for more details. 



## Author

**Md Rasheduzzaman**  
Full-Stack Software Engineer & Technical Project Manager  

Building scalable, secure & AI-powered SaaS platforms across ERP, HRMS, CRM, LMS, and E-commerce domains.  
Over 10 years of experience leading full-stack teams, cloud infrastructure, and enterprise-grade software delivery.

**🌐 Portfolio:** [jmrashed.github.io](https://jmrashed.github.io/)  
**✉️ Email:** [jmrashed@gmail.com](mailto:jmrashed@gmail.com)  
**💼 LinkedIn:** [linkedin.com/in/jmrashed](https://www.linkedin.com/in/jmrashed/)  
**📝 Blog:** [medium.com/@jmrashed](https://medium.com/@jmrashed)  
**💻 GitHub:** [github.com/jmrashed](https://github.com/jmrashed)

---

> *“Need a Reliable Software Partner? I build scalable, secure & modern solutions for startups and enterprises.”*