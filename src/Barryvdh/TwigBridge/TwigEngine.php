<?php
namespace Barryvdh\TwigBridge;

use Illuminate\View\Engines\EngineInterface;
use Twig_Environment;

/**
 * Laravel view engine for Twig.
 */
class TwigEngine implements EngineInterface
{

    protected $environment;

    /**
     * Constructor.
     *
     * @param \Twig_Environment           $environment A \Twig_Environment instance
     */
    public function __construct(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function get($path, array $data = array()){

        //Strip the full path to leave to name
        foreach(\App::make('twig.path') as $dir){
            $path =  str_replace($dir, '', $path);
        }
        $path = ltrim($path, '/');

        return $this->load($path)->render($data);
    }

    /**
     * Loads the given template.
     *
     * @param mixed $name A template name or an instance of Twig_Template
     *
     * @return \Twig_TemplateInterface A \Twig_TemplateInterface instance
     *
     * @throws \InvalidArgumentException if the template does not exist
     */
    protected function load($name)
    {
        if ($name instanceof \Twig_Template) {
            return $name;
        }

        try {
            return $this->environment->loadTemplate($name);
        } catch (\Twig_Error_Loader $e) {
            throw new \InvalidArgumentException("Error in $name: ". $e->getMessage(), $e->getCode(), $e);
        }
    }

}