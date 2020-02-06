<!-- Form used to edit a course -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $courseID = $_POST['courseID'];
    $courseName = $_POST['courseName'];
    $courseLevel = $_POST['courseLevel'];
    $courseLeader = $_POST['courseLeader'];

	$query = "UPDATE course SET courseName='$courseName', courseLevel='$courseLevel', courseLeader='$courseLeader', lastUpdated = now() WHERE courseID='$courseID'";

	if ($connection->query($query) === TRUE) {
	    echo "Course: $courseID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/courselist.php");

    $connection->close();

?>
