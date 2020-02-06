<!-- Script used to edit deadlines -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $deadlineID = $_POST['deadlineID'];
    $deadlineName = $_POST['deadlineName'];
    $deadlineWeighting = $_POST['deadlineWeighting'];
    $deadlineDate = $_POST['deadlineDate'];

	$query = "UPDATE deadlines SET deadlineName='$deadlineName', deadlineWeighting='$deadlineWeighting', deadlineDate='$deadlineDate', lastUpdated = now() WHERE deadlineID='$deadlineID'";

	if ($connection->query($query) === TRUE) {
	    echo "Deadline: $deadlineName edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/deadlines.php");

    $connection->close();

?>
