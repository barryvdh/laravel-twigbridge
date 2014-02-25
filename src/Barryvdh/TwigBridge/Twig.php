<?php namespace Barryvdh\TwigBridge;

use Illuminate\Support\Facades\Facade;

class Twig extends Facade {

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor() {
        return 'twig';
    }

}
