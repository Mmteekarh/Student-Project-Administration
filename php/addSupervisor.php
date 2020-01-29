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

    $supervisorID = $_POST['supervisorID'];
	$supervisorTitle = $_POST['supervisorTitle'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $officeNumber = $_POST['officeNumber'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $active = $_POST['activeSupervisor'];
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

	$query = "INSERT INTO supervisor (supervisorID, supervisorTitle, firstName, lastName, activeSupervisor, officeNumber, emailAddress, password, dateAdded, loggedIn, admin)
	VALUES ('$supervisorID', '$supervisorTitle', '$firstName', '$lastName', $activeSupervisor, '$officeNumber', '$emailAddress', '$password', now(), 0, $adminRow)";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Supervisor: $firstName $lastName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/addsupervisor.php");

    $connection->close();

?>