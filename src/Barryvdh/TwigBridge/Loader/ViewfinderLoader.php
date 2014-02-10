<?php
namespace Barryvdh\TwigBridge\Loader;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;
use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;
use InvalidArgumentException;
use Twig_Error_Loader;

class ViewfinderLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{

    protected $finder;
    protected $files;
    protected $extension;
    protected $cache = array();

    public function __construct(FileViewFinder $finder, $extension = 'twig'){
        $this->finder = $finder;
        $this->files = $finder->getFilesystem();
        $this->extension = $extension;
    }

    protected function findTemplate($name){

        if(isset($this->cache[$name])){
            return $this->cache[$name];
        }elseif($this->files->exists($name)){
            return $this->cache[$name] = $name;
        }else{
            $view = $name;
            $ext = ".".$this->extension;
            $len = strlen($ext);
            if(substr($view, -$len) == $ext){
                $view = substr($view, 0, -$len);
            }

            try {
                $this->cache[$name] = $this->finder->find($view);
            } catch (InvalidArgumentException $e) {
                throw new Twig_Error_Loader($e->getMessage());
            }
            return $this->cache[$name];
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        return $this->files->get( $this->findTemplate($name) );
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        try {
            $this->findTemplate($name);
            return true;
        } catch (Twig_Error_Loader $exception) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return $this->files->lastModified( $this->findTemplate($name) ) <= $time;
    }
}
