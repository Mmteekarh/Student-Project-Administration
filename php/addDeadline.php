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

	$deadlineName = $_POST['deadlineName'];
    $deadlineWeighting = $_POST['deadlineWeighting'];
    $deadlineDate = $_POST['deadlineDate'];

	$query = "INSERT INTO deadlines (deadlineName, deadlineWeighting, deadlineDate)
	VALUES ('$deadlineName', '$deadlineWeighting', '$deadlineDate')";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Deadline: $deadlineName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/deadlines.php");

    $connection->close();

?>
