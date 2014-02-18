<?php
namespace Barryvdh\TwigBridge\Extension;

use  Illuminate\Config\Repository;


class ConfigExtension extends \Twig_Extension
{
    protected $config;

    public function __construct(Repository $config){
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_config';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('config_get', array($this->config, 'get'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('config_has', array($this->config, 'has'), array('is_safe' => array('html'))),
        );
    }

}
