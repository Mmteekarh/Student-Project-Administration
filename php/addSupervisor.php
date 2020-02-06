<!-- Script for adding a supervisor to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $supervisorID = $_POST['supervisorID'];
	$supervisorTitle = $_POST['supervisorTitle'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $officeNumber = $_POST['officeNumber'];
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $active = $_POST['activeSupervisor'];
    $admin = $_POST['admin'];

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

	$query = "INSERT INTO supervisor (supervisorID, supervisorTitle, firstName, lastName, activeSupervisor, officeNumber, emailAddress, password, loggedIn, admin, dateCreated, lastUpdated)
	VALUES ('$supervisorID', '$supervisorTitle', '$firstName', '$lastName', $activeSupervisor, '$officeNumber', '$emailAddress', '$password', 0, $adminRow, now(), now())";

	if ($connection->query($query) === TRUE) {
	    echo "Supervisor: $firstName $lastName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/supervisorlist.php");

    $connection->close();

?>