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
            if($root = $this->resolve($facade)){
                $facades[$facade] = $root;
            }
        }
        return $facades;
    }

    protected function resolve($name){
        if(class_exists($name) && is_callable("$name::getFacadeRoot")){
            return $name::getFacadeRoot();
        }else{
            return false;
        }
    }

}
