<!-- Script used to edit supervisors -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $supervisorID = $_POST['supervisorID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $active = $_POST['activeSupervisor'];
    $officeNumber = $_POST['officeNumber'];
    $emailAddress = $_POST['emailAddress'];
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

	$query = "UPDATE supervisor SET firstName = '$firstName', lastName = '$lastName', activeSupervisor = $activeSupervisor, officeNumber = '$officeNumber', emailAddress = '$emailAddress', admin = $adminRow, lastUpdated = now() WHERE supervisorID = '$supervisorID'";

	if ($connection->query($query) === TRUE) {
	    echo "Supervisor: $supervisorID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/supervisorlist.php");

    $connection->close();

?>
