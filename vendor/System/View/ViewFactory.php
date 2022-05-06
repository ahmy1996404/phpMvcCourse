<?php

namespace System\View;

use System\Application;

class ViewFactory
{
    /** 
     * Application Object
     * 
     * @var \System\Application
     */
    private $app;
    
    /**
     * constructor
     *
     * @param  \System\Application $app
     * 
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }    
    /**
     * render the given view path with the passed variables
     *
     * @param  string $viewPath
     * @param  array $data
     * @return \System\View\ViewInterface
     */
    public function render($viewPath , array $data = [])
    {
        return new View($this->app->file,$viewPath , $data); 
    }
}
