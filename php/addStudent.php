<?php

    $ip = $_SERVER['REMOTE_ADDR'];
    $currentDate = date("Y/m/d H:i:sa");

    // Attempts to make a connection to the database with given fields.
    $connection = mysqli_connect("localhost", "phpaccess", "t5eXXf0@s3", "SPAS");
           
    // If the connection failed, log an error and print a user-friendly message.
    if($connection === false){
        echo "ERROR: at " . $currentDate . " by " . $ip . " Caused by: " . mysqli_connect_error();
        die("Oh no! There was a connection error, please contact an administrator.");
    }

    $studentID = $_POST['studentID'];
    $firstName = $_POST['firstName'];
    $middleInitial = $_POST['middleInitial'];
    $lastName = $_POST['lastName'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $plp = $_POST['plp'];
    $password = $_POST['password'];

	$query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password)
	VALUES ('$studentID', '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', '$plp', '$password')";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Student: $firstName $lastName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

    $connection->close();

?>