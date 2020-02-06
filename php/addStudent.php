<!-- Script for adding a student to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $studentID = $_POST['studentID'];
    $firstName = $_POST['firstName'];
    $middleInitial = $_POST['middleInitial'];
    $lastName = $_POST['lastName'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $plp = $_POST['plp'];
    $password = $_POST['password'];
    $courseID = $_POST['courseID'];

	$query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password, courseID, dateCreated, lastUpdated)
	VALUES ('$studentID', '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', '$plp', '$password', '$courseID', now(), now())";

	if ($connection->query($query) === TRUE) {
	    echo "Student: $firstName $lastName added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

    $connection->close();

?>