<?php

namespace System;

class Session
{    
    /**
     * application object
     *
     * @var \System\Application
     */
    private $app;
    
    /**
     * constructor
     *
     * @param  \System\Application
     * 
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function set($key , $value)
    {
        echo $key . ' => ' . $value;
    }
    

}
