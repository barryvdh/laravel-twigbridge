<?php
namespace Barryvdh\TwigBridge\Extension;

use  Illuminate\Html\FormBuilder;
use  Illuminate\Support\Str;

class FormExtension extends \Twig_Extension
{
    protected $form;

    public function __construct(FormBuilder $form){
        $this->form = $form;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_form';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        $form = $this->form;
        return array(
            new \Twig_SimpleFunction('form_*', function($name) use($form){
                $arguments = array_slice(func_get_args(), 1);
                $name = Str::camel($name);
                return call_user_func_array(array($form, $name), $arguments);
            }, array('is_safe' => array('html')))
        );
    }
}
