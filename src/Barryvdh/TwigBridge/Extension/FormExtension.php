<?php
namespace Barryvdh\TwigBridge\Extension;

use  Illuminate\Html\FormBuilder;


class FormExtension extends \Twig_Extension
{
    protected $form;

    public function __construct(FormBuilder $form){
        $this->form = $form;
    }

    public function getName(){
        return 'laravel_form';
    }

    public function getFunctions(){
        $form = $this->form;
        return array(
            new \Twig_SimpleFunction('form_*', function($name) use($form){
                $arguments = array_slice(func_get_args(), 1);
                return call_user_func_array(array($form, $name), $arguments);
            }, array('is_safe' => array('html'))),

        );
    }

}
