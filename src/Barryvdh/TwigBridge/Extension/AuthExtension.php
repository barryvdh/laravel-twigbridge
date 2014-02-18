<?php
namespace Barryvdh\TwigBridge\Extension;

use Illuminate\Auth\AuthManager;


class AuthExtension extends \Twig_Extension
{
    protected $auth;

    public function __construct(AuthManager $auth){
        $this->auth = $auth;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(){
        return 'laravel_auth';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('auth_check', array($this->auth, 'check')),
            new \Twig_SimpleFunction('auth_guest', array($this->auth, 'guest')),
            new \Twig_SimpleFunction('auth_user', array($this->auth, 'user')),
        );
    }

}
