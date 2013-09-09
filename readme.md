### Laravel 4 TwigBridge

## Very alpha, if you need to use Twig in production, use https://github.com/rcrowe/TwigBridge

Trying out some different things, to match the Silex ServiceProvider more closely (same container bindings etc). Als basic filter/function helpers for Laravel and possibility to call Facades.

Require this package in your composer.json and run composer update (or run `composer require barryvdh/laravel-twigbridge:dev-master` directly):

    "barryvdh/laravel-twigbridge": "dev-master"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

    'Barryvdh\TwigBridge\ServiceProvider',

Change your config to choose what helpers/filters you want to use, and what Facades to register.

Functions:

    {{ asset('img.jpg') }}

Filters:

    {{ name | studly_case }}

Facades:

    {{ URL.to('/') }}