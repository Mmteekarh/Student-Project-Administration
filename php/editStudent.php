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

    $stuID = $_POST['stuID'];
    $middleInitial = $_POST['middleInitial'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $plp = $_POST['plp'];


	$query = "UPDATE student SET firstName='$firstName', middleInitial='$middleInitial', lastName='$lastName', yearOfStudy='$yearOfStudy', plp='$plp' WHERE studentID='$stuID'";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Student: $stuID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

    $connection->close();

?>