<?php

namespace Barryvdh\TwigBridge\Tests;

use Barryvdh\TwigBridge\TwigEngine;

class TwigEngineTest extends \PHPUnit_Framework_TestCase
{

    public function testRender()
    {
        $engine = $this->getTwig();
        $this->assertSame('foo', $engine->get('index'));
    }

    /**
     * @expectedException \Twig_Error_Syntax
     */
    public function testRenderWithError()
    {
        $engine = $this->getTwig();
        $engine->get('error');
    }
    
    /**
     * @expectedException \Twig_Error_Loader
     */
    public function testRenderNotFound()
    {
        $engine = $this->getTwig();
        $engine->get('404');
    }

    protected function getTwig()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Array(array(
            'index' => 'foo',
            'error' => '{{ foo }',
        )));

        return new TwigEngine($twig);
    }
}
