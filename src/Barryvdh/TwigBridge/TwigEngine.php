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
     * @param \Twig_Environment $environment A Twig_Environment instance
     */
    public function __construct(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Twig_Error if something went wrong like a thrown exception while rendering the template
     * @throws \Twig_Error_Loader if the template cannot be loaded
     */
    public function get($path, array $data = array())
    {
        $template = $this->environment->loadTemplate($path);
        
        if($template instanceof TwigTemplate){
            //Events are already fired by the View Environment
            $template->setFiredEvents(true);
        }
        
        return $template->render($data);
    }

}
