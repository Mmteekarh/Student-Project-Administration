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


    $superID = $_POST['superID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $active = $_POST['activeSupervisor'];
    $officeNumber = $_POST['officeNumber'];
    $emailAddress = $_POST['emailAddress'];
    $admin = $_POST['admin'];
    $activeSupervisor;
    $adminRow;

    if($active == "Yes") {
        $activeSupervisor = 1;
    } else if ($active == "No") {
        $activeSupervisor = 0;
    } else {
        $activeSupervisor = 0;
    }

    if($admin == "Yes") {
        $adminRow = 1;
    } else if ($admin == "No") {
        $adminRow = 0;
    } else {
        $adminRow = 0;
    }

	$query = "UPDATE supervisor SET firstName='$firstName', lastName='$lastName', activeSupervisor=$activeSupervisor, officeNumber='$officeNumber', emailAddress='$emailAddress', admin=$adminRow WHERE supervisorID='$superID'";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Supervisor: $superID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/supervisorlist.php");

    $connection->close();

?>
