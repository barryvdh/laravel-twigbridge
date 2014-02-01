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
     * @param \Twig_Environment $environment A \Twig_Environment instance
     */
    public function __construct(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     *
     * It also supports \Twig_Template as name parameter.
     *
     * @throws \Twig_Error if something went wrong like a thrown exception while rendering the template
     */
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
     * @param string|TemplateReferenceInterface|\Twig_Template $name A template name or an instance of Twig_Template
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
            return $this->environment->loadTemplate((string) $name);
        } catch (\Twig_Error_Loader $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

}