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
    /**
     * start session
     *
     * @return void
     */
    public function start()
    {
        ini_set('session.use_only_cookies', 1);
        if (! session_id()){
            session_start();
        }
    }    
    /**
     * set new value to Session
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function set($key , $value)
    {
        $_SESSION[$key] = $value;
    }
        
    /**
     * get value from session by the given key
     *
     * @param  string $key
     * @param mixed $default
     * @return void
     */ 
    public function get($key , $default = null )
    {
        return array_get($_SESSION , $key , $default);   
    }
    /**
     * determine if the session has the given key
     * 
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * remove the given key from session
     *
     * @param  mixed $key
     * @return void
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
    
    /**
     * get value from session by the given key then remove it
     *
     * @param  string $key
     * @return void
     */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }
        
    /**
     * Get all session data
     *
     * @return array
     */
    public function all()
    {
         return $_SESSION;
    }
    
    /**
     * destroy session
     *
     * @return void
     */
    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }

}
