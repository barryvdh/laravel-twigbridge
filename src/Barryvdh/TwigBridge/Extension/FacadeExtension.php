<?php
namespace Barryvdh\TwigBridge\Extension;

use Twig_Extension;

class FacadeExtension extends Twig_Extension
{

    protected $facades;

    public function __construct(){
        $this->facades = \Config::get('laravel-twigbridge::facades', array());
    }

    public function getName(){
        return 'facade_extension';
    }

    public function getGlobals(){
        $facades = array();
        foreach($this->facades as $facade){
            $caller = new ClassCaller;
            $caller->setClass($facade);
            $facades[$facade] = $caller;
        }
        return $facades;
    }

}
