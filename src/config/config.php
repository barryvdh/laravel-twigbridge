<?php
use Illuminate\Support\Facades\Config;

return array(

 /*
  |--------------------------------------------------------------------------
  | Twig options
  |--------------------------------------------------------------------------
  |
  | Available options:
  |
  |   * debug: When set to true, it automatically set "auto_reload" to true as
  |           well (default to false).
  |
  |   * charset: The charset used by the templates (default to UTF-8).
  |
  |   * base_template_class: The base template class to use for generated
  |                         templates (default to Barryvdh\TwigBridge\TwigTemplate).
  |
  |   * cache: An absolute path where to store the compiled templates, or
  |           false to disable compilation cache. Default to storage_path('views/twig')
  |
  |   * auto_reload: Whether to reload the template if the original source changed.
  |                 If you don't provide the auto_reload option, it will be
  |                 determined automatically based on the debug value.
  |
  |   * strict_variables: Whether to ignore invalid variables in templates
  |                      (defaults to false).
  |
  |   * autoescape: Whether to enable auto-escaping (default to html):
  |                   * false: disable auto-escaping
  |                   * true: equivalent to html
  |                   * html, js: set the autoescaping to one of the supported strategies
  |                   * PHP callback: a PHP callback that returns an escaping strategy based on the template "filename"
  |
  |   * optimizations: A flag that indicates which optimizations to apply
  |                   (default to -1 which means that all optimizations are enabled;
  |                   set it to 0 to disable).
  |
  */

  'options' => array(
    'debug'                 => Config::get('app.debug'),
    'charset'               => 'UTF-8',
    'base_template_class'   => 'Barryvdh\TwigBridge\TwigTemplate',
    'auto_reload'           => null,
    'cache'                 => storage_path('twig'),
    'strict_variables'      => true,
    'autoescape'            => 'html',
    'optimizations'         => -1,
  ),

  /*
   |--------------------------------------------------------------------------
   | Functions & Filters
   |--------------------------------------------------------------------------
   |
   | List of Functions & Filters that are made available to your Twig templates.
   | Supports string, array, closure or Twig_SimpleFilter / Twig_SimpleFunction.
   | The default options are used when no options are set.
   |
   */

  'default_options' => array(
    'needs_environment' => false,
    'needs_context'     => false,
    'is_safe'           => null, // null or array('html')
    'is_safe_callback'  => null, // null or callback
    'pre_escape'        => null, // null or 'html'
    'preserves_safety'  => null,
  ),

  'functions' => array(

  ),

  'filters' => array(

  ),

  'facades' => array(

  )

);
