<?php

    class AlternativeUserRepository{
        
        private $db;
        private $index;

        public function __construct(){
            $this->db = [];
            $this->index = 0;
        }

        public function create(Array $input){
            try{
                $this->index += 1;
                $key = strval($this->index);

                $surname = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $userData = [
                    'surname' => $surname,
                    'firstName' => $firstName,
                    'email' => $email
                ];

                $this->db[$key] = $userData;
                return $this->index;
                return 'creation successful';
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function findAll(){
            try{
                return $this->db;
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

                $userData = [
                    'surname' => $surname,
                    'firstName' => $firstName,
                    'email' => $email
                ];

                $key = strval($userId);
                $db[$key] = $userData;
                
                return "update successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function delete($userId){
            try{
                $key = strval($userId);
                unset($db[$key]);
                
                return "delete successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }
    } // end class