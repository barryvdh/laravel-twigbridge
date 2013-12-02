<?php

namespace Barryvdh\TwigBridge;

use Twig_Template;
use Illuminate\View\View;

/**
 * Default base class for compiled templates.
 */
abstract class TwigTemplate extends Twig_Template
{

    /**
     * {@inheritdoc}
     */
    public function display( array $context, array $blocks = array())
    {
        $name = $this->getTemplateName();
        //The first time, PathLoader is used so we only have the full path, not a name. The first creator/composers are run from View::make, so just skip that.
        if(!is_file($name)){
            /** @var \Illuminate\View\Environment $env */
            $env  = $context['__env'];
            \View::callCreator($view = new View($env, $env->getEngineResolver()->resolve('twig'), $name, null, $context));
            \View::callComposer($view);
            $context = $view->getData();
        }

        parent::display($context, $blocks);

    }

    /**
     * {@inheritdoc}
     */
    protected function getAttribute($object, $item, array $arguments = array(), $type = Twig_Template::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false){
        if(
            Twig_Template::METHOD_CALL !== $type //Don't handle Method Calls
            and is_a($object,'Illuminate\Database\Eloquent\Model') //Only handle Models
        ){
            return $object->getAttribute($item);
        }else{
            return parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
        }
    }
}
