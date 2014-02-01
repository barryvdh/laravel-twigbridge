<?php
namespace Barryvdh\TwigBridge\Extension;

use Illuminate\Routing\UrlGenerator;


class UrlExtension extends \Twig_Extension
{
    protected $url;

    public function __construct(UrlGenerator $url){
        $this->url = $url;
    }

    public function getName(){
        return 'laravel_url';
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('asset', array($this->url, 'asset'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('action', array($this->url, 'action'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('url', array($this->url, 'to'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('route', array($this->url, 'route'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('secure_url', array($this->url, 'secure'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('secure_asset', array($this->url, 'secureAsset'), array('is_safe' => array('html'))),
        );
    }

}
