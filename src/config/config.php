<?php

return array(


 /*
  |--------------------------------------------------------------------------
  | Twig options
  |--------------------------------------------------------------------------
  |
  | Standard Twig settings; http://twig.sensiolabs.org/doc/api.html#environment-options
  |
  */
    'options' => array(
        'debug' => Config::get('app.debug'),
        'strict_variables' => Config::get('app.debug'),
        'auto_reload' =>  Config::get('app.debug'),
        'autoescape' => true,
    ),


  /*
   |--------------------------------------------------------------------------
   | Functions & Filters
   |--------------------------------------------------------------------------
   |
   | List of Functions & Filters that are made available to your Twig templates.
   | Supports string or closure.
   |
   */
    'functions' => array(
        // Urls
        'route',
        'action',
        'asset',
        'url',
        'link_to',
        'link_to_asset',
        'link_to_route',
        'link_to_action',
        'secure_asset',
        'secure_url',
        // Translation
        'trans',
        'trans_choice',
        // Miscellaneous
        'csrf_token',
    ),

    'filters' => array(
        //Strings
        'camel_case',
        'snake_case',
        'studly_case',
        'str_finish',
        'str_plural',
        'str_singular'
    )


);
