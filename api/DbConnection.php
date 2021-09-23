<?php 

namespace Api;
use mysqli;
use Exception;

class DbConnection{
    private $connection = null;

    public function __construct(){

        try{
            $hostname = 'localhost';
            $database ='php_crud';
            $username = 'root'; // replace this with your mysql username
            $password = 'uchenna'; // replace this with your mysql username
            
            // connect to mysql and store the connection in a variable
            $this->connection = new mysqli($hostname, $username, $password, $database);
    
            // check for connection errors
            if ($this->connection->connect_error) die($this->connection->connect_error);
        } catch(Exception $e){
            $errorMessage = $e->getMessage();
            die($errorMessage);
        }

        
    }

    public function getConnection() {
        return $this->connection;
    }
}