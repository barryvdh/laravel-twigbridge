<?php namespace Barryvdh\TwigBridge\Extension;

class ClassCaller{

    protected $class;
    public function  setClass($class){
        $this->class = $class;
    }

    public function __call($name, $arguments){
        return call_user_func_array($this->class.'::'.$name, $arguments);
    }
}