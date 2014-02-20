<?php

namespace Barryvdh\TwigBridge;

use Twig_Template;
use Illuminate\View\View;

/**
 * Default base class for compiled templates.
 */
abstract class TwigTemplate extends Twig_Template
{
    protected $firedEvents = false;
    
    /**
     * {@inheritdoc}
     */
    public function display( array $context, array $blocks = array())
    {
        $context = $this->fireEvents($this->env->mergeGlobals($context));
        $this->displayWithErrorHandling($context, $blocks);
    }
    
    /**
     * Fire the creator/composer events to merge context data.
     * @param $context
     * @throws \Twig_Error_Runtime
     * @return array
     */
    protected function fireEvents($context){
        // Only fire events once
        if($this->firedEvents or !isset($context['__env'])){
            return $context;
        }

        /** @var \Illuminate\View\Environment $env */
        $env  = $context['__env'];
        
        try{
            $env->callCreator($view = new View($env, $env->getEngineResolver()->resolve('twig'), $this->getTemplateName(), null, $context));
        }catch(\Exception $e){
            throw new \Twig_Error_Runtime(sprintf('An exception has been thrown during the View Creator of a template ("%s").', $e->getMessage()), -1, $this->getTemplateName(), $e);
        }

        try{
            $env->callComposer($view);
        }catch(\Exception $e){
            throw new \Twig_Error_Runtime(sprintf('An exception has been thrown during the View Composer of a template ("%s").', $e->getMessage()), -1, $this->getTemplateName(), $e);
        }

        $this->setFiredEvents(true);

        return $view->getData();
    }

    /**
     * Set the firedEvents flag, to make sure composers/creators only fire once.
     *
     * @param bool $fired
     */
    public function setFiredEvents($fired=true){
        $this->firedEvents = $fired;
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
