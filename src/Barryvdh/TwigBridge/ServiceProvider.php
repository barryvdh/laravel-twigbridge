<?php namespace Barryvdh\TwigBridge;

use Barryvdh\TwigBridge\Extension\AuthExtension;
use Barryvdh\TwigBridge\Extension\ConfigExtension;
use Barryvdh\TwigBridge\Extension\FacadeExtension;
use Barryvdh\TwigBridge\Extension\FormExtension;
use Barryvdh\TwigBridge\Extension\HelperExtension;
use Barryvdh\TwigBridge\Extension\HtmlExtension;
use Barryvdh\TwigBridge\Extension\SessionExtension;
use Barryvdh\TwigBridge\Extension\StringExtension;
use Barryvdh\TwigBridge\Extension\TranslatorExtension;
use Barryvdh\TwigBridge\Extension\UrlExtension;

use Barryvdh\TwigBridge\Console\ClearCommand;
use Symfony\Bridge\Twig\Command\LintCommand;

/**
 * Twig integration for Laravel 4
 *
 * Based on Twig integration for Silex by Fabien Potencier <fabien@symfony.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        $app = $this->app;
        $app['twig.options'] = array();
        $app['twig.form.templates'] = array();
        $app['twig.path'] = $app->share(function($app){
            return $app['view']->getFinder()->getPaths();
        });
        $app['twig.templates'] = array();

        $app['twig'] = $app->share(function ($app) {
                $app['twig.options'] = array_replace(
                    array(
                        'debug' => $app['config']['app.debug'],
                        'cache' => $app['path.storage'].'/views/twig',
                        'base_template_class' => 'Barryvdh\TwigBridge\TwigTemplate',
                    ),
                    $app['config']->get('laravel-twigbridge::config.options', array()),
                    $app['twig.options']
                );

                $twig = new \Twig_Environment($app['twig.loader'], $app['twig.options']);
                $twig->addGlobal('app', $app);
                foreach ($app['view']->getShared() as $key => $value)
                {
                    $twig->addGlobal($key, $value);
                }

                if ( $app['twig.options']['debug']) {
                    $twig->addExtension(new \Twig_Extension_Debug());
                }

                $twig->addExtension(new AuthExtension($app['auth']));
                $twig->addExtension(new ConfigExtension($app['config']));
                $twig->addExtension(new FacadeExtension());
                $twig->addExtension(new FormExtension($app['form']));
                $twig->addExtension(new HelperExtension());
                $twig->addExtension(new HtmlExtension($app['html']));
                $twig->addExtension(new UrlExtension($app['url']));
                $twig->addExtension(new SessionExtension($app['session']));
                $twig->addExtension(new StringExtension());
                $twig->addExtension(new TranslatorExtension($app['translator']));

                return $twig;
            });

        $app['twig.loader.viewfinder'] = $app->share(function ($app) {
                $extension = $app['config']->get('laravel-twigbridge::config.extension', 'twig');
                return new Loader\ViewfinderLoader($app['view']->getFinder(), $extension);
            });

        $app['twig.loader.filesystem'] = $app->share(function ($app) {
                return new \Twig_Loader_Filesystem($app['twig.path']);
            });

        $app['twig.loader.array'] = $app->share(function ($app) {
                return new \Twig_Loader_Array($app['twig.templates']);
            });

        $app['twig.loader'] = $app->share(function ($app) {
                return new \Twig_Loader_Chain(array(
                    $app['twig.loader.array'],
                    $app['twig.loader.viewfinder'],
                    $app['twig.loader.filesystem'],
                ));
            });

        $this->registerCommands();
	}

    /**
     * Register the cache related console commands.
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->app['command.twig.clear'] = $this->app->share(
            function ($app) {
                return new ClearCommand($app['twig'], $app['files']);
            }
        );

        $this->app['command.twig.lint'] = $this->app->share(
            function ($app) {
                $lintCommand =  new LintCommand('twig:lint');
                $lintCommand->setTwigEnvironment($app['twig']);
                return $lintCommand;
            }
        );

        $this->commands(
            'command.twig.clear', 'command.twig.lint'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'twig',
            'twig.form.templates', 'twig.path', 'twig.templates', 'twig.options',
            'twig.loader', 'twig.loader.viewfinder', 'twig.loader.array', 'twig.loader.filesystem',
            'command.twig.clear', 'command.twig.lint'
        );
    }
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(){

        $app = $this->app;

        $this->package('barryvdh/laravel-twigbridge');
        $extension = $app['config']->get('laravel-twigbridge::config.extension', 'twig');

        // Register the view engine:
        $app['view']->addExtension($extension, 'twig', function () use ($app)
        {
            return new TwigEngine($app['twig']);
        });
    }

}