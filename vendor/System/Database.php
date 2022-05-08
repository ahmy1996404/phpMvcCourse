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
     * Table name
     * 
     * @var string
     */
    private $table;
    /**
     * data container
     * 
     * @var array
     */
    private $data=[];
    /**
     * Binding container
     * 
     * @var array
     */
    private $bindings=[];
    /**
     * Last Insert id  
     * 
     * @var int
     */
    private $lastId;
     /**
     * wheres
     * 
     * @var array
     */
    private $wheres=[];
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
        static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        static::$connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
        static::$connection->exec('SET NAMES utf8');

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
    /**
     * Set the table name
     * 
     * @param string $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
     /**
     * Set the table name
     * 
     * @param string $table
     * @return $this
     */
    public function from($table)
    {
        return $this->table($table);
    }
     /**
     * Set the data that will be stored in database table
     * 
     * @param mixed $key
     * @param mixed $value
     * @return $this
     */
    public function data($key,$value = null)
    {
        if(is_array($key)){
            $this->data = array_merge($this->data , $key);
            $this->addToBindings($key);
        }else{
            $this->data[$key] = $value;
            $this->addToBindings($value);

        }
        return $this;
    }
    /** 
     * Insert Data to database
     * 
     * @param string $table
     * @return $this
     */
    public function insert($table = null)
    {
        if($table){
            $this->table($table);
        }
        $sql = 'INSERT INTO '.$this->table . ' SET ';
        $sql .= $this->setFields();
        
        $this->query($sql , $this->bindings);
        $this->lastId = $this->connection()->lastInsertId();
        return $this;
    }
    /** 
     * Update Data in database
     * 
     * @param string $table
     * @return $this
     */
    public function update($table = null)
    {
        if($table){
            $this->table($table);
        }
        $sql = 'UPDATE '.$this->table . ' SET ';
        $sql .= $this->setFields();
       
        if($this->wheres){
            $sql .= ' WHERE '. implode('' , $this->wheres);
        }
        $this->query($sql , $this->bindings);
        return $this;
    }
    /**
     * set fields for insert and update
     * 
     * @return string
     */
    public function setFields()
    {
        $sql = '';
        foreach (array_keys($this->data)  as $key ) {
            $sql .= '`' . $key . '` = ? , ';
        }
        $sql= rtrim($sql , ', ');
        return $sql;
    }
    /**
     * Add new where clause
     * 
     * @return $this
     */
    public function where()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->wheres[] = $sql;
        return $this;
    }
    /**
     * Execute the given Sql statment
     * 
     * @return \PDOStatement
     */
    public function query()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        if(count($bindings)==1 AND is_array($bindings[0])){
            $bindings = $bindings[0];
        }
        try {
             $query = $this->connection()->prepare($sql);
            foreach($bindings as $key => $value){
                $query->bindValue($key + 1, _e($value));
            }

            $query->execute();
            return $query; 
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /**
     * Get last insert id
     * 
     *  @return int 
     */
    public function lastId()
    {
        return $this->lastId;
    }
    /**
     * add the given value to bindings
     * 
     * @param mixed $value
     * @return void
     */
    public function addToBindings($value)
    {
        if(is_array($value)){
            $this->bindings=array_merge($this->bindings , array_values($value));
        }else{
            $this->bindings[] = $value;
        }
    }
}
