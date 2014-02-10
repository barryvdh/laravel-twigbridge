<?php

namespace Barryvdh\TwigBridge\Tests\Loader;

use Mockery as m;
use Barryvdh\TwigBridge\TwigEngine;
use Barryvdh\TwigBridge\Loader\ViewfinderLoader;

class TwigEngineTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testExistingPath()
    {
        $filesystem = m::mock('Illuminate\Filesystem\Filesystem');
        $filesystem->shouldReceive('exists')->with('index.twig')->once()->andReturn(true);

        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('getFilesystem')->andReturn($filesystem);

        $loader = $this->getLoader($finder);

        $this->assertTrue($loader->exists('index.twig'));

    }

    public function testViewFinderExists()
    {

        $filesystem = m::mock('Illuminate\Filesystem\Filesystem');
        $filesystem->shouldReceive('exists')->with('index')->once()->andReturn(false);

        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('getFilesystem')->andReturn($filesystem);
        $finder->shouldReceive('find')->with('index')->once()->andReturn('/path/to/index.twig');

        $loader = $this->getLoader($finder);

        $this->assertTrue($loader->exists('index'));

    }

    public function testViewFinderGet()
    {

        $filesystem = m::mock('Illuminate\Filesystem\Filesystem');
        $filesystem->shouldReceive('exists')->with('index')->once()->andReturn(false);
        $filesystem->shouldReceive('get')->with('/path/to/index.twig')->once()->andReturn('foo');


        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('getFilesystem')->andReturn($filesystem);
        $finder->shouldReceive('find')->with('index')->once()->andReturn('/path/to/index.twig');

        $loader = $this->getLoader($finder);
        $engine = $this->getTwig($loader);

        $this->assertSame('foo', $engine->get('index'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedException \Twig_Error_Loader
     */
    public function testNotFound(){

        $filesystem = m::mock('Illuminate\Filesystem\Filesystem');
        $filesystem->shouldReceive('exists')->with('index')->once()->andReturn(false);


        $finder = m::mock('Illuminate\View\FileViewFinder');
        $finder->shouldReceive('getFilesystem')->andReturn($filesystem);
        $finder->shouldReceive('find')->with('index')->once()->andThrow('InvalidArgumentException');

        $loader = $this->getLoader($finder);
        $engine = $this->getTwig($loader);

        $engine->get('index');

    }



    protected function getTwig($loader)
    {
        $twig = new \Twig_Environment($loader);

        return new TwigEngine($twig);
    }

    protected function getLoader($finder){
        return new ViewfinderLoader($finder, '.twig');
    }

}
