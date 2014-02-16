<?php namespace Barryvdh\TwigBridge\Extension;

class StaticCaller{

    protected $className;

    /**
     * Create a new StaticCaller instance.
     * @param string $className The class to call
     */
    public function __construct($className){
        $this->className = $className;
    }

    /**
     * Dynamically call a method on the class
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments){
        return call_user_func_array($this->className.'::'.$method, $arguments);
    }
}