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

    "barryvdh/laravel-twigbridge": "0.3.x"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php

```php
'Barryvdh\TwigBridge\ServiceProvider',
```

You can add the Twig Facade to have easy access to Twig_Environment, ie. `Twig::render('template.twig')`.

```php
'Twig' => 'Barryvdh\TwigBridge\Twig',
```

### Usage
After install, you can just use View::make('index');
The .twig extension should be omitted in the View::make() call, just like Blade files. Within your Twig files, you can reference them with or without .twig.
You can also use view composers/creators, just like in Blade templates.

```php
View::composer('profile', function($view)
{
	$view->with('count', User::count());
});
```

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
 * url_* (All the URL::* methods, snake_cased)
 
Filters:
 * camel_case, snake_case, studly_case
 * str_* (All the Str::* methods, snake_cased)
 
Global variables:
 * app: the Illuminate\Foundation\Application object
 * errors: The $errors MessageBag from the Validator (always available)


### Example Template Syntax

In a Blade template, if you had a route to edit a task in a Task/Todo application, you would use the following syntax to link to a route.

    {{ link_to_route('tasks.edit', 'Edit', $task->id, array('class' => 'btn btn-primary')) }}

In a Twig template you would do the same thing using the following syntax. Notice the task object drops the dollar sign (`$`) and instead of an arrow (`->`) you use a period (`'.'`). Also, you convert the array to a Python/Javascript dictionary type syntax.

    {{ link_to_route('tasks.edit', 'Edit', task.id, {'class': 'btn btn-primary'}) }}
 
 
### Commands

2 Artisan commands are included:
 * `$ php artisan twig:clear`
    - Clear the compiled views in the Twig Cache
 * `$ php artisan twig:lint <dir or filename>`
    - Check a directory or file for Twig errors, for exampele `php artisan twig:lint app/views`
    
### Configure
To publish a configuration file, you can run the following command:

```
$ php artisan config:publish barryvdh/laravel-twigbridge
```

Change your config to choose what helpers/filters you want to use, and what Facades to register. You can also pass in a callback or array to define options.
You can also use an instance of Twig_SimpleFunction or Twig_SimpleFilter. Besides facades, you can also add your Models.

```php
'functions' => array(
	'simple_function',
	'class_function' => 'MyClass@method',
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
```

### Extend

The Twig_Environment is available as 'twig' in the App Container, so you can access it via app('twig') or App::make('twig').
The ChainLoader is 'twig.loader', the array templates are in 'twig.templates'.
You can also use the Twig Facade to access the Twig_Environment functions directly.

```php
//Using the App container
$twig = app('twig');
$twig->addFunction(new Twig_SimpleFunction(..));

$loader = App::make('twig.loader');
$loader->addLoader($myLoader);

//Using the Facade
Twig::addGlobal('key', $value);
Twig::addFunction(new Twig_SimpleFunction(..));
Twig::getLoader()->addLoader($myLoader);

//Adding templates to the array loader
App::extend('twig.templates', function($templates){
        $templates['hello'] = 'Hello World!';
        return $templates;
    });
echo Twig::render('hello'); //Hello World!
 ```
