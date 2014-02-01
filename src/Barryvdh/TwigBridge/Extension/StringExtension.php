<?php
namespace Barryvdh\TwigBridge\Extension;

class StringExtension extends \Twig_Extension
{

    public function getName(){
        return 'laravel_string';
    }

    public function getFilters(){
        return array(
            new \Twig_SimpleFilter('camel_case', array('Illuminate\Support\Str', 'camel'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('snake_case', array('Illuminate\Support\Str', 'snake'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('studly_case', array('Illuminate\Support\Str', 'studly'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('str_*', function($name){
                $arguments = array_slice(func_get_args(), 1);
                return call_user_func_array(array('Illuminate\Support\Str', $name), $arguments);
            }, array('is_safe' => array('html'))),

        );
    }

}
