<?php
namespace Barryvdh\TwigBridge\Extension;

use Illuminate\Session\SessionManager;


class SessionExtension extends \Twig_Extension
{
    protected $session;

    public function __construct(SessionManager $session){
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_session';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('csrf_token', array($this->session, 'token'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('session_get', array($this->session, 'get')),
            new \Twig_SimpleFunction('session_has', array($this->session, 'has')),
        );
    }

}
