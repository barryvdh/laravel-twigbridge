<?php

namespace Barryvdh\TwigBridge\Loader;

use Twig_Loader_Chain;
use Twig_Error_Loader;
use Twig_ExistsLoaderInterface;

class ChainLoader extends Twig_Loader_Chain implements FilenameLoaderInterface{

    /**
     * {@inheritdoc}
     */
    public function getFilename($name)
    {
        $exceptions = array();
        foreach ($this->loaders as $loader) {
            if (!$loader instanceof FilenameLoaderInterface || ($loader instanceof Twig_ExistsLoaderInterface && !$loader->exists($name))) {
                continue;
            }

            try {
                return $loader->getFilename($name);
            } catch (Twig_Error_Loader $e) {
                $exceptions[] = $e->getMessage();
            }
        }

        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined (%s).', $name, implode(', ', $exceptions)));
    }
}