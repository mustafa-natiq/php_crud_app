<?php 
    require 'DbConnection.php';

    class UserRepository{
        private $db = null;

        public function __construct($db){
            $this->db = $db;
        }

        public function create(Array $input){
            try{
                $surame = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $this->db->->query("insert into users(surname, firstName, email) values('$surname', '$firstName', '$email')");
                $this->db->close();
                return "creation successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function findAll(){
            try{
                $result = $this->db->query("select * from users");
                $result = $result->fetch_all(MYSQLI_ASSOC);
                $this->db->close();
                return $result;
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function update($userEmail, Array $input){
            try{
                $surame = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $this->db->->query("update users set surname = '$surname', firstName = '$firstName', email = '$email' where email = '$userEmail' ");
                $this->db->close();
                return "update successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function delete($userEmail){
            try{
                $this->db->query("delete from users where email = '$userEmail' ");
                return "delete successful"
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }
    } // end class

?> 