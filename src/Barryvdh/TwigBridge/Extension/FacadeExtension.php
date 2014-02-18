<?php
namespace Barryvdh\TwigBridge\Extension;

use Twig_Extension;

class FacadeExtension extends Twig_Extension
{
    protected $facades;

    public function __construct($facades){
        $this->facades = $facades;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'facade_extension';
    }

    /**
     * {@inheritDoc}
     */
    public function getGlobals(){
        $globals = array();
        foreach($this->facades as $className){
            $globals[$className] = new StaticCaller($className);
        }
        return $globals;
    }

}
