<?php
namespace Barryvdh\TwigBridge\Extension;

use  Illuminate\Translation\Translator;


class TranslatorExtension extends \Twig_Extension
{
    protected $translator;

    public function __construct(Translator $translator){
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_translator';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('trans', array($this->translator, 'trans'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('trans_choice', array($this->translator, 'transChoice'), array('is_safe' => array('html'))),
        );
    }

}
