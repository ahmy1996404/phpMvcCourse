<?php

namespace System;
use PDO;
use PDOException;
class Database
{
    /**
     * Application obj
     * 
     * @var \System\Application
     */
    private $app;
    /** 
     * Pdo Connection
     * 
     * @var \PDO
     */
    private static $connection;
    /**
     * Constructor
     * @param \System\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        if (! $this->isConnected()){
            $this->connect();
        }
    }
    /**
     * Determine if there is ant connection to database
     * 
     * @return bool
     */
    private function isConnected()
    {
        return static::$connection instanceof PDO;
    }
    /**
     * connect to database
     * 
     * @return bool
     */
    private function connect()
    {
        $connectionData = $this->app->file->call('config.php');
        extract($connectionData);
        
        try {
            static::$connection  = new PDO(
            'mysql:host='.$server.';'.'dbname='.$dbname.';',
            $dbuser,
            $dbpass,
        );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /**
     * Get DataBase Conection Object PDO Object
     * 
     * @return \PDO
     */
    public function connection()
    {
        return static::$connection;
    }
}
