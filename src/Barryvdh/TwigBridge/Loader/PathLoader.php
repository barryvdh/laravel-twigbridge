<?php
namespace Barryvdh\TwigBridge\Loader;

use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;

class PathLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{


    protected function findTemplate($name){
        return $name;
    }
    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        return file_get_contents( $this->findTemplate($name) );
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return is_file($this->findTemplate($name));
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        return md5($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return filemtime( $this->findTemplate($name) ) <= $time;
    }
}