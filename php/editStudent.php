<!-- Script used to edit a student -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $studentID = $_POST['studentID'];
    $middleInitial = $_POST['middleInitial'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $plp = $_POST['plp'];
    $courseID = $_POST['courseID'];

	$query = "UPDATE student SET firstName = '$firstName', middleInitial = '$middleInitial', lastName = '$lastName', yearOfStudy = '$yearOfStudy', plp = '$plp', courseID = '$courseID', lastUpdated = now() WHERE studentID = '$studentID'";

	if ($connection->query($query) === TRUE) {
	    echo "Student: $studentID edited successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

    $connection->close();

?>