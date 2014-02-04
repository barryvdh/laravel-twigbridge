## Laravel 4 TwigBridge

This packages adds Twig as a Laravel Template Engine:

* Use .twig files just like Blade/PHP Templates
* Supports creator/composer events
* Easily add helpers/filters (`{{ url('/') }}` or `{{ 'someThing' | snake_case }}`)
* Can call Facades (`{{ MyModel.to('/') }}`)
* Can be integrated with Assetic (https://github.com/barryvdh/laravel-assetic)
* Default extensions for easier use.

See http://twig.sensiolabs.org/ for more info about Twig Templating
    
### Install
Require this package in your composer.json and run composer update (or run `composer require barryvdh/laravel-twigbridge:dev-master` directly):

    "barryvdh/laravel-twigbridge": "dev-master"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

    'Barryvdh\TwigBridge\ServiceProvider',
    
### Usage
After install, you can just use View::make('index.twig'); or just View::make('index');
The .twig extension is not needed when creating the view, but some IDE's provide autocomplete when you use .twig (in Twig files).
You can also use view composers/creators, just like in Blade templates.

View::composer('profile.twig', function($view)
    {
        $view->with('count', User::count());
    });


### Extensions

The following helpers/filters are added by the default Extensions. They are based on the helpers and/or facades, so should be self explaining.

Functions:
 * asset, action, url, route, secure_url, secure_asset
 * link_to, link_to_asset, link_to_route, link_to_action
 * auth_check, auth_guest, auth_user
 * config_get, config_has
 * session_has, session_get, csrf_token
 * trans, trans_choice
 * form_* (All the Form::* methods, snake_cased)
 * html_* (All the Html::* methods, snake_cased)
 * str_* (All the Str::* methods, snake_cased)
 
Filters:
 * camel_case, snake_case, studly_case
 * str_* (All the Str::* methods, snake_cased)
 
Global variables:
 * app: the Illuminate\Foundation\Application object
 * errors: The $errors MessageBag from the Validator (always available)
 
 
### Commands

2 Artisan commands are included:
 * `$ php artisan twig:clear`
    - Clear the compiled views in the Twig Cache
 * `$ php artisan twig:lint <dir or filename>`
    - Check a directory or file for Twig errors, for exampele `php artisan twig:lint app/views`
    
### Configure
Change your config to choose what helpers/filters you want to use, and what Facades to register. You can also pass in a callback or array to define options.
You can also use an instance of Twig_SimpleFunction or Twig_SimpleFilter. Besides facades, you can also add your Models.

    'functions' => array(
        'simple_function',
        'other_function' => array(
            'is_safe' => array('html')
        ),
        'call_me' => array(
            'is_safe' => array('html'),
            'callback' => function($value){ 
                    return phone($value);
                }
        )
    ),

    'filters' => array(
        'filter_this' => function($value){
                return doSomething($value);
            }
    ),

    'facades' => array(
        'Auth', 
        'MyModel'
    )
    
### Extend

The Twig_Environment is available in \App::make('twig'), so you can change the lexer, add Extensions etc.
 
