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


    $courseID = $_POST['courseID'];
    $courseName = $_POST['courseName'];
    $courseLevel = $_POST['courseLevel'];
    $courseLeader = $_POST['courseLeader'];

	$query = "UPDATE course SET courseName='$courseName', courseLevel='$courseLevel', courseLeader='$courseLeader' WHERE courseID='$courseID'";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Course: $courseID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/courselist.php");

    $connection->close();

?>
