<?php

namespace Barryvdh\TwigBridge\Loader;

use Twig_Error_Loader;

/**
 * Adds an getFilename() method for loaders, to get the template source file.
 *
 */
interface FilenameLoaderInterface
{
    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getFilename($name);
}