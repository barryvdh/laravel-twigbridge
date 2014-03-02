<?php
namespace Barryvdh\TwigBridge\Loader;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewFinderInterface;
use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;
use InvalidArgumentException;
use Twig_Error_Loader;

class ViewfinderLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface, FilenameLoaderInterface
{

    protected $finder;
    protected $files;
    protected $extension;
    protected $cache = array();

    /**
     * Constructor.
     *
     * @param ViewFinderInterface $finder The FileViewFinder instance to look
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string $extension
     */
    public function __construct(ViewFinderInterface $finder, Filesystem $files, $extension = 'twig'){
        $this->finder = $finder;
        $this->files = $files;
        $this->extension = $extension;
    }

    /**
     * Find the path of a template
     *
     * @param string $name The name of the template to load
     *
     * @return string The path of the template file.
     *
     * @throws Twig_Error_Loader When $name is not found
     */
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

    /**
     * {@inheritdoc}
     */
    public function getFilename($name)
    {
        return $this->findTemplate($name);
    }
}
