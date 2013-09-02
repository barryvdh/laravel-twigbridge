<?php
namespace Barryvdh\TwigBridge\Extension;

use InvalidArgumentException;
use Twig_Extension;

class LaravelHelperExtension extends Twig_Extension
{

    public function getName(){
        return 'laravel_helper_extension';
    }

    public function getFunctions(){

        $functions = array();
        $helper_functions = array(
            'asset',
            'link_to',
            'action',
            'url',
            'trans',
            'trans_choice'
        );

        foreach ($helper_functions as $method => $twigFunction) {
            if (is_string($twigFunction)) {
                $methodName = $twigFunction;
            } elseif (is_callable($twigFunction)) {
                $methodName = $method;
            } else {
                throw new InvalidArgumentException('Incorrect function type');
            }

            $function = new \Twig_SimpleFunction($methodName, function () use ($twigFunction) {
                return call_user_func_array($twigFunction, func_get_args());
            });

            $functions[] = $function;
        }

        return $functions;
    }

    public function getFilters()
    {
        $filters = array();

        $helper_filters = array(

            'camel_case',
            'snake_case',
            'studly_case',
            'plural',
            'singular',
            'trans',
            'trans_choice',
            'str_finish'

        );

        foreach ($helper_filters as $method => $twigFilter) {
            if (is_string($twigFilter)) {
                $methodName = $twigFilter;
            } elseif (is_callable($twigFilter)) {
                $methodName = $method;
            } else {
                throw new InvalidArgumentException('Incorrect function filter');
            }

            $function = new \Twig_SimpleFilter($methodName, function () use ($twigFilter) {
                return call_user_func_array($twigFilter, func_get_args());
            });

            $filters[] = $function;
        }



        return $filters;
    }


}
