<?php
namespace Barryvdh\TwigBridge\Extension;

use Twig_Extension;

class HelperExtension extends Twig_Extension
{
    protected $filters;
    protected $functions;
    protected $defaults;

    public function __construct($functions = array(), $filters = array(), $defaults = array())
    {
        $this->functions = $functions;
        $this->filters = $filters;
        $this->defaults = $defaults;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'laravel_helper_extension';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        $functions = array();
        foreach ($this->functions as $method => $callable) {
            if(is_a($callable, 'Twig_SimpleFunction')){
                $function = $callable;
            }else{
                list($method, $callable, $options) = $this->parseCallable($method, $callable);
                $function = new \Twig_SimpleFunction($method, $callable, $options);
            }
            $functions[] = $function;
        }

        return $functions;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        $filters = array();
        foreach ($this->filters as $method => $callable) {
            if(is_a($callable, 'Twig_SimpleFilter')){
                $filter = $callable;
            }else{
                list($method, $callable, $options) = $this->parseCallable($method, $callable);
                $filter = new \Twig_SimpleFilter($method, $callable, $options);
            }
            $filters[] = $filter;
        }
        return $filters;
    }

    /**
     * Parse the method/callable
     *
     * @param $method
     * @param $callable
     * @return array
     */
    protected function parseCallable($method, $callable){
        $options = $this->defaults;
        //If options array, extract the callable
        if(is_array($callable)){
            $options = $callable;
            if(isset($options['callback'])){
                $callable = $options['callback'];
                unset($options['callback']);
            }else{
                $callable = $method;
            }
        }
        //If string, split on the @ for Laravel style calling methods on classes
        if (is_string($callable)) {
            //Numeric index, methodname should be the callable string.
            if(!is_string($method)){
                $method = $callable;
            }
            if(strpos($callable,'@') !== false){
                $callable = explode('@', $callable,2);
            }
        }
        return array($method, $callable, $options);
    }

}
