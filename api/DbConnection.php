<?php 

class DbConnection{
    private $connection = null;

    public function __construct(){

        try{
            $hostname = 'localhost';
            $database ='php_crud';
            $username = 'root';
            $password = '';
            
            $surname =  $_POST['surname'];
            $firstName = $_POST['firstName'];
            $email = $_POST['email'];
    
            // connect to mysql and store the connection in a variable
            $this->connection = new mysqli($hostname, $username, $password, $database);
    
            // check for connection errors
            if ($connection->connect_error) die($connection->connect_error);
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