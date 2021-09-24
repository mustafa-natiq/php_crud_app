<?php 

    namespace Api;
    use Exception;

    class UserRepository{
        private $db = null;

        public function __construct($db){
            $this->db = $db;
        }

        public function create(Array $input){
            try{
                $surname = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $this->db->query("insert into users(surname, firstName, email) values('$surname', '$firstName', '$email')");
                $this->db->close();
                return 'creation successful';
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

        public function update($userId, Array $input){
            try{
                $surname = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $this->db->query("update users set surname = '$surname', firstName = '$firstName', email = '$email' where id = '$userId' ");
                $this->db->close();
                return "update successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function delete($userId){
            try{
                $this->db->query("delete from users where id = '$userId' ");
                return "delete successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }
    } // end class