<?php 

class DbConnection{
    private $connection = null;

    public function __construct(){

        try{
            $hostname = 'localhost';
            $database ='php_crud';
            $username = 'root';
            $password = '';
            
            // connect to mysql and store the connection in a variable
            $this->connection = new mysqli($hostname, $username, $password, $database);
    
            // check for connection errors
            if ($this->connection->connect_error) die($connection->connect_error);
        } catch(Exception $e){
            $errorMessage = $e->getMessage();
            die($errorMessage);
        }

        
    }

    public function getConnection() {
        return $this->connection;
    }
}

?>