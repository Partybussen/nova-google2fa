## 383project/nova-google2fa

This package enables 2FA on Laravel Nova.

### Activation

- User gets recovery codes.

![Recovery codes](docs/images/recovery-codes.png)

- User activates 2FA on his device.

![Activate 2FA](docs/images/register.png)

### Verification

- User verifies login with 2FA.

![Enter 2FA](docs/images/enter-code.png)

### Recovery

- If user enters an invalid code, recovery button is shown.

![Enter 2FA](docs/images/invalid-code.png)

- User enters a recovery code.

![Enter 2FA](docs/images/enter-recovery-code.png)

- User is redirected to activation process.

## Installation

Installation is only available via composer

``` composer.json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/sanderbaas/nova-google2fa"
    }
]

"require": {
    "sanderbaas/nova-google2fa": "dev-master"
}
```

Publish config and migrations

``` bash
$ php artisan vendor:publish --provider="Project383\Google2fa\ToolServiceProvider"
$ php artisan vendor:publish --provider="PragmaRX\Google2FALaravel\ServiceProvider"
```

Run migrations

``` bash
$ php artisan migrate
```

Add relation to User model
```php
use Project383\Google2fa\Models\User2fa;

...

/**
 * @return HasOne
 */
public function user2fa(): HasOne
{
    return $this->hasOne(User2fa::class);
}
```

Add middleware to `config/nova.php`.
```php
[
    ...
    'middleware' => [
        ...
        \Project383\Google2fa\Http\Middleware\Google2fa::class,
        ...
    ],
]
```

## Config

```php
return [
    /**
     * Disable or enable middleware.
     */
    'enabled' => env('GOOGLE_2FA_ENABLED', true),

    'models' => [
        /**
         * Change this variable to path to user model.
         */
        'user' => 'App\User',
        
        /**
         * Change this if you need a custom connector
         */
        'user2fa' => User2fa::class,
    ],
    'tables' => [
        /**
         * Table in which users are stored.
         */
        'user' => 'users',
    ],

    'recovery_codes' => [
        /**
         * Number of recovery codes that will be generated.
         */
        'count'          => 8,

        /**
         * Number of blocks in each recovery code.
         */
        'blocks'         => 3,

        /**
         * Number of characters in each block in recovery code.
         */
        'chars_in_block' => 16,

        /**
         * The following algorithms are currently supported:
         *  - PASSWORD_DEFAULT
         *  - PASSWORD_BCRYPT
         *  - PASSWORD_ARGON2I // available from php 7.2
         */
        'hashing_algorithm' => PASSWORD_BCRYPT,
    ],
];
```


## License

MIT license. Please see the [license file](docs/license.md) for more information.
