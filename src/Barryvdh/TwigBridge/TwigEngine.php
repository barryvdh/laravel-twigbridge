<?php
namespace Barryvdh\TwigBridge;

use Illuminate\View\Engines\EngineInterface;
use Twig_Environment;

/**
 * Laravel view engine for Twig.
 */
class TwigEngine implements EngineInterface
{

    protected $twig;

    /**
     * Constructor.
     *
     * @param \Twig_Environment $twig A \Twig_Environment instance
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function get($path, array $data = array())
    {
        $template = $this->load($path);
        
        if($template instanceof TwigTemplate){
            //Events are already fired by the View Environment
            $template->setFiredEvents(true);
        }
        
        return $template->render($data);
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
            return $this->twig->loadTemplate($name);
        } catch (\Twig_Error_Loader $e) {
            throw new \InvalidArgumentException("Error in $name: ". $e->getMessage(), $e->getCode(), $e);
        }
    }

}