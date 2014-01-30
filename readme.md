## Laravel 4 TwigBridge

An alternative to https://github.com/rcrowe/TwigBridge which is more similar to the Silex TwigServiceProvider and supports:
    - Using .twig files just like Blade/PHP Templates
    - Supports creator/composer events
    - Easily add helpers/filters (`{{ url('/') }}` or `{{ 'someThing' | snake_case }}`)
    - Can call Facades (`{{ URL.to('/') }}`)
    - Can be integrated with Assetic (https://github.com/barryvdh/laravel-assetic)
    
### Install
Require this package in your composer.json and run composer update (or run `composer require barryvdh/laravel-twigbridge:dev-master` directly):

    "barryvdh/laravel-twigbridge": "dev-master"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

    'Barryvdh\TwigBridge\ServiceProvider',

### Configure
Change your config to choose what helpers/filters you want to use, and what Facades to register.

Functions:

    {{ asset('img.jpg') }}

Filters:

    {{ name | studly_case }}

Facades:

    {{ URL.to('/') }}