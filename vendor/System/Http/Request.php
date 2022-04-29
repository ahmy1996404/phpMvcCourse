<?php

namespace  System\Http;

class Request
{    
    /**
     * url
     *
     * @var string
     */
    private $url;    
    
    /**
     * Base Url
     *
     * @var string
     */
    private $baseUrl;
    /**
     * prepare Url
     *
     * @return void
     */
    public function prepareUrl()
    {
        $script = dirname($this->server('SCRIPT_NAME'));
        $requestUri = $this->server('REQUEST_URI');
        if(strpos($requestUri,'?')!==false){
            list($requestUri,$queryString) = explode('?',$requestUri);
        }
        $this->url = preg_replace('#^'.$script.'#','',$requestUri);
        $this->baseUrl = $this->server('REQUEST_SCHEME') . '://' . $this->server('HTTP_HOST') . $script . '/';
    }    
    /**
     * get Value from _GET by the given key 
     *
     * @param  string $key
     * @param  mixed $default
     * @return void
     */
    public function get($key , $default = null )
    {
        return array_get($_GET , $key , $default);

    }    
    /**
     * get Value from _POST by the given key 
     *
     * @param  mixed $key
     * @param  mixed $default
     * @return void
     */
    public function post($key , $default = null )
    {
        return array_get($_POST , $key , $default);

    }
    public function server($key , $default = null )
    {
        return array_get($_SERVER , $key , $default);
    }    
    /**
     * Get current request method
     *
     * @return void
     */
    public function method()
    {
        return $this->server('REQUEST_METHOD');
    }    
    /**
     * Get full url of the script
     *
     * @return string
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }
        
    /**
     * get only relative url (clean url)
     *
     * @return string
     */
    public function url()
    {
        return $this->url();
    }

}
