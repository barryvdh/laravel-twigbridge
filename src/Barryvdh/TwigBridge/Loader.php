<?php
namespace Barryvdh\TwigBridge;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder ;
use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;

class Loader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{

    protected $finder;
    protected $files;

    protected $cache = array();
    public function __construct(FileViewFinder $finder){
        $this->finder = $finder;
        $this->files = $finder->getFilesystem();
    }

    protected function getPath($name){


        $key = $this->getCacheKey($name);

        if(isset($this->cache[$key])){
            return $this->cache[$key];
        }else{
            if(file_exists($name)){
                return $name;
            }else{
                if(substr($name, -5) == '.twig'){
                    $name = substr($name, 0, -5);
                }
                return $this->cache[$key] = $this->finder->find($name);
            }

        }
    }
    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        return $this->files->get( $this->getPath($name) );
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return $this->files->exists($this->getPath($name));
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
        return $this->files->lastModified( $this->getPath($name) ) <= $time;
    }
}