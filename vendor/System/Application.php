<?php
namespace System;
class Application
{
    /**
     * Container
     * 
     * @var array
     */
    private $container = [];
    /**
     * Constractor 
     * 
     * @param \System\File $file
     */

     public function __construct(File $file)
     {
         $this->share('file',$file);

         $this->registerClasses();

         $this->loadHelpers();
     }
     /**
      * Run the Application
      *
      * @return void
      */
      public function run()
      {
          $this->session->start();
          $this->request->prepareUrl();
      }
     /**
      * Register classes in spl auto load register
      *
      * @return void
      */
      private function registerClasses()
      {
          spl_autoload_register([$this,'load']);
      }
      /**
       * Load Class throgh auto loading
       * 
       * @param string $class 
       * @return void
       */
      public function load($class)
      { 
          
          if (strpos($class , 'App')===0){
            $file = $this->file->to($class . '.php');
          }else{
              //get the class from vendor
              $file= $this->file->toVendor($class . '.php');
              
          }
           if ($this->file->exists($file)){
                $this->file->require($file);
            }
      }
      /**
       * Load helpers file
       * 
       *  
       * @return void
       */
      private function loadHelpers()
      {
          $this->file->require($this->file->toVendor('helpers.php'));
      }

      /**
       * Get Shared Value 
       * 
       * @param string $key 
       * @return mixed
       */
      public function get($key)
      {
          if(! $this->isSharing($key)){
              if ($this->isCoreAlias($key)){
                  $this->share($key , $this->createNewCoreObject($key));
              }else{
                die('<b>'.$key . '</b> not found in application container');
              }
          }
          return $this->container[$key];
      }
      /** 
       * Determine if the given key is shared through Application
       * 
       * @param string $key
       * @return bool
       */
      public function isSharing($key)
      {
          return isset($this->container[$key]);
      }
      /**
       * Determine if the given key is an alias to core class
       * 
       * @param string $alias
       * @return bool
       */
      public function isCoreAlias($alias)
      {
          $coreClasses = $this->coreClasses();
          return isset($coreClasses[$alias]);
      }
      /**
      * create new object for the core class based on the given alias
      * @param string $alias
      * @return object
      */
      public function createNewCoreObject($alias)
      {
          $coreClasses = $this->coreClasses();
          $object = $coreClasses[$alias];
          return new $object($this);
      }
     /**
      * Share the given key|value Through Application
      * @param string $key
      * @param mixed $value
      * @return mixed
      */
      public function share($key , $value)
      {
          $this->container[$key] = $value;
      }
      /**
       * Get All Core Classes with its alaises
       * @return array
       */
      public function coreClasses()
      {
           return[
               'request'    => 'System\\Http\\Request',
               'response'    => 'System\\Http\\Response',
               'session'    => 'System\\Session',
               'cookie'    => 'System\\Cookie',
               'load'    => 'System\\Loader',
               'html'    => 'System\\Html',
               'db'    => 'System\\Database',
               'view'    => 'System\\View\\ViewFactory',
           ];
      }
      /**
       * Get shared value dynimically
       * 
       * @param string $key
       * @return mixed
       */
      public function __get($key)
      {
          return $this->get($key);
      }
}