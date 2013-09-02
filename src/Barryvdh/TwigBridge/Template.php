<?php

namespace Barryvdh\TwigBridge;

use Twig_Template;


/**
 * Default base class for compiled templates.
 */
abstract class Template extends Twig_Template
{

    public function display(array $context, array $blocks = array())
    {
        //Remove the extension if needed
        $template_name = $this->getTemplateName();
        if(\Str::endsWith($template_name, '.twig')){
            $template_name = substr($template_name, 0, -5);
        }

        // Check the events and if needed, call the creator and composer
        $dispatcher = \App::make('events');
        if ($dispatcher->hasListeners('composing: '.$template_name) or $dispatcher->hasListeners('creating: '.$template_name)) {

            $env  = $context['__env'];

            \View::callCreator($view = new \Illuminate\View\View($env, $env->getEngineResolver()->resolve('twig'), $template_name, null, $context));

            \View::callComposer($view);

            $context = $view->getData();
        }

        parent::display($context, $blocks);
    }

    protected function getAttribute($object, $item, array $arguments = array(), $type = Twig_Template::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false){

        if( ! is_object($object) or ! isset($object->{$item})){
           $value = parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
        }else{
            $value = $object->{$item};
        }
        return $value;

    }


}
