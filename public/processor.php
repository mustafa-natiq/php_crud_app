<?php 

    try{
        // variables needed for connection to mysql
	$hostname = 'localhost';
	$database ='php_crud';
	$username = 'root';
    $password = '';
    
    $surname =  $_POST['surname'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];

	// connect to mysql and store the connection in a variable
	$connection = new mysqli($hostname, $username, $password, $database);

	// check for connection errors
    if ($connection->connect_error) die($connection->connect_error);
    
    // insert values into the users table
    $insertQuery = $connection->query("insert into users(surname, firstName, email) values('$surname', '$firstName', '$email')");
    if(!$insertQuery) die($connection->error);

	// store the sql query in a variable
	$retrievalQuery = "select surname, firstName, email from users";

	// store the result of the query in a variable
	$result = $connection->query($retrievalQuery);

	// check if a result for the query was obtained, otherwise throw an error
	if (!$result) die($connection->error);

	// store the total number of rows in a variable.
	// this will be needed to loop through each row
    $rows = $result->num_rows;	
	
	// loop through each row and print out the result
	for($i = 0; $i < $rows; $i++) {
		// verify that the current row is what we seek
		$result->data_seek($i);

		// fetch the current row and store it in a variable
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $index = $i + 1;

		// print out each column in the row
		echo '<b>ID:</b> ' . $index . '<br>';
		echo '<b>SURNAME:</b> ' . $row['surname'] . '<br>';
		echo '<b>FIRST_NAME:</b> ' .$row['firstName'] . '<br>';
		echo '<b>EMAIL:</b> ' . $row['email'] . '<br><br>';

		
	}
	
	// close the connection to mysql
        $connection->close();
        
    } catch(Exception $e){
       $errorMessage = $e->getMessage();
       echo "$errorMessage";
    }
	