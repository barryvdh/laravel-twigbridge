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
       
    ),

    'filters' => array(
      
    ),

    'facades' => array(
      
    )


);
