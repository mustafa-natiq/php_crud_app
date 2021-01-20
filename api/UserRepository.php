<?php 
    require 'DbConnection.php';

    class UserRepository{
        private $db = null;

        __construct($db){
            $this->db = $db;
        }

        public function create(Array $input){
            try{
                $surame = $input['surname'];
                $firstName = $input['firstName'];
                $email = $input['email'];

                $insertQuery = $this->db->->query("insert into users(surname, firstName, email) values('$surname', '$firstName', '$email')");
                $this->db->close();
                return "creation successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function findAll(){
            try{
                    
                    $retrievalQuery = $this->db->query("select surname, firstName, email from users");

                    // check if a result for the query was obtained, otherwise throw an error
                    if (!$retrievalQuery) die($this->db->error);

                    // store the total number of rows in a variable.
                    // this will be needed to loop through each row
                    $rows = $retrievalQuery->num_rows;	
                    
                    // loop through each row and print out the retrievalQuery
                    for($i = 0; $i < $rows; $i++) {
                        // verify that the current row is what we seek
                        $retrievalQuery->data_seek($i);

                        // fetch the current row and store it in a variable
                        $row = $retrievalQuery->fetch_array(MYSQLI_ASSOC);
                        $index = $i + 1;

                        // print out each column in the row
                        echo '<b>ID:</b> ' . $index . '<br>';
                        echo '<b>SURNAME:</b> ' . $row['surname'] . '<br>';
                        echo '<b>FIRST_NAME:</b> ' .$row['firstName'] . '<br>';
                        echo '<b>EMAIL:</b> ' . $row['email'] . '<br><br>';

                        }

                        $this->db->close();
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

                $updateQuery = $this->db->->query("update users set surname = '$surname', firstName = '$firstName', email = '$email' where email = '$userEmail' ");
                $this->db->close();
                return "update successful";
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }

        public function delete($userEmail){
            try{
                $deleteQuery = $this->db->query("delete from users where email = '$userEmail' ");
                return "delete successful"
            } catch(Exception $e){
                $errorMessage = $e->getMessage();
                die($errorMessage);
            }
        }
    } // end class

?> 