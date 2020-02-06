<!-- Script for adding deadlines to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

	$deadlineName = $_POST['deadlineName'];
    $deadlineWeighting = $_POST['deadlineWeighting'];
    $deadlineDate = $_POST['deadlineDate'];

	$query = "INSERT INTO deadlines (deadlineName, deadlineWeighting, deadlineDate, dateCreated, lastUpdated)
	VALUES ('$deadlineName', '$deadlineWeighting', '$deadlineDate', now(), now())";

	if ($connection->query($query) === TRUE) {
	    echo "Deadline: $deadlineName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/deadlines.php");

    $connection->close();

?>
