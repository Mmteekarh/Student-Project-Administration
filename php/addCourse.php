<!-- Script for adding a course to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $courseID = $_POST['courseID'];
	$courseName = $_POST['courseName'];
    $courseLevel = $_POST['courseLevel'];
    $courseLeader = $_POST['courseLeader'];

	$query = "INSERT INTO course (courseID, courseName, courseLevel, courseLeader, dateCreated, lastUpdated)
	VALUES ('$courseID', '$courseName', '$courseLevel', '$courseLeader', now(), now())";

	if ($connection->query($query) === TRUE) {
	    echo "Course: $courseName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/courselist.php");

    $connection->close();

?>
