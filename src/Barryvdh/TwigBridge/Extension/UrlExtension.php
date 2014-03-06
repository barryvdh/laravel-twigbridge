<?php
namespace Barryvdh\TwigBridge\Extension;

use Illuminate\Routing\UrlGenerator;
use  Illuminate\Support\Str;

class UrlExtension extends \Twig_Extension
{
    protected $url;

    public function __construct(UrlGenerator $url){
        $this->url = $url;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_url';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        $url = $this->url;
        return array(
            new \Twig_SimpleFunction('asset', array($url, 'asset'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('action', array($url, 'action'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('url', array($this, 'url'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('route', array($url, 'route'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('secure_url', array($url, 'secure'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('secure_asset', array($url, 'secureAsset'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('url_*', function($name) use($url){
                    $arguments = array_slice(func_get_args(), 1);
                    $name = Str::camel($name);
                    return call_user_func_array(array($url, $name), $arguments);
                })
        );
    }

    public function url($path = null, $parameters = array(), $secure = null){
        return $this->url->to($path, $parameters, $secure);
    }
}
