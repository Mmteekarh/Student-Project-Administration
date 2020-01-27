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

    $supervisorID = getNextID($connection);
	$supervisorTitle = $_POST['supervisorTitle'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $officeNumber = $_POST['officeNumber'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $active = $_POST['activeSupervisor'];
    $activeSupervisor;

    echo $active;

    if($active == "Yes") {
        $activeSupervisor = 1;
    } else if ($active == "No") {
        $activeSupervisor = 0;
    } else {
        $activeSupervisor = 0;
    }

	$query = "INSERT INTO supervisor (supervisorID, supervisorTitle, firstName, lastName, activeSupervisor, officeNumber, emailAddress, password, dateAdded, loggedIn)
	VALUES ('$supervisorID', '$supervisorTitle', '$firstName', '$lastName', $activeSupervisor, '$officeNumber', '$emailAddress', '$password', now(), 0)";

	if ($result = mysqli_query($connection, $query)) {
	    echo "Supervisor: $firstName $lastName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/addsupervisor.php");

    function getNextID($connection) {
        $supervisorID = "";
        
        $query = "SELECT COUNT(*) AS total FROM supervisor";

        if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $supervisorID = $row["total"] + 1;
                }
            }
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }

        return $supervisorID;
    }

    $connection->close();

?>