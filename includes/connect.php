<!-- Establishes a connection to the database. -->
<?php

    // Includes the "vars" file to get IP address and date.
	include 'vars.php';

	// Attempts to make a connection to the database with host -> username -> password -> database name.
	$connection = new mysqli("localhost", "phpaccess", "t5eXXf0@s3", "SPAS");
           
    // If the connection failed, log an error including the date and IP address of the user.
    if($connection->connect_error) {
        echo '<div class="alert alert-danger" role="alert">
              		Fatal Error: MySQL connection error at ' . $currentDate . ' by ' . $ip . '. Caused by: ' . $connection->connect_error . '  
              </div>';
    }

?>