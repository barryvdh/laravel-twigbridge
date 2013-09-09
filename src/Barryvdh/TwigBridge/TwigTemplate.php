<?php

namespace Barryvdh\TwigBridge;

use Twig_Template;


/**
 * Default base class for compiled templates.
 */
abstract class TwigTemplate extends Twig_Template
{

    protected function getViewName(){
        $name = $this->getTemplateName();

        return $name;


    }
    public function display( array $context, array $blocks = array())
    {

        //The first time, PathLoader is used so we only have the full path, not a name. The first creator/composers are run from View::make, so just skip that.
        if(!is_file($this->getTemplateName())){

            $env  = $context['__env'];
            \View::callCreator($view = new \Illuminate\View\View($env, $env->getEngineResolver()->resolve('twig'), $this->getViewName(), null, $context));

            \View::callComposer($view);

            $context = $view->getData();
        }

        parent::display($context, $blocks);
    }

    protected function getAttribute($object, $item, array $arguments = array(), $type = Twig_Template::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false){

        if(
            Twig_Template::METHOD_CALL !== $type //Don't handle Method Calls
            and is_a($object,'Illuminate\Database\Eloquent\Model') //Only handle Models
         /*   and (
                isset($object->{$item})     //Normal attribute
                or $object->hasGetMutator($item)    //via Mutator
                or method_exists($object, camel_case($item))    //Relation
            )*/
        ){
            return $object->getAttribute($item);
        }else{
            return parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
        }

    }


}
