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

	$projectTitle = $_POST['projectTitle'];
	$supervisorID = 1;
    $courses = $_POST['courses'];
    $projectID = $_POST['projectID'];
    $projectBrief = $_POST['projectBrief'];
    $maximumStudents = $_POST['maximumStudents'];
    $projectCode = $_POST['projectCode'];


	$query = "UPDATE project SET projectTitle='$projectTitle', projectBrief='$projectBrief', maximumStudents='$maximumStudents', projectCode='$projectCode', lastEdited=now() WHERE projectID='$projectID'";

    $removeProjectCourse = "DELETE FROM projectCourse WHERE projectID='$projectID'";

    if ($result = mysqli_query($connection, $removeProjectCourse)) {
        echo "Course Pair: $projectID removed successfully";
    } else {
        echo "Error: " . $removeProjectCourse . "<br>" . $connection->error;
    }

    foreach($courses as $item) {

        $projectCourseQuery = "INSERT INTO projectCourse (projectID, courseID) VALUES ('$projectID','$item')";

        if ($result = mysqli_query($connection, $projectCourseQuery)) {
            echo "Course Pair: $item : $projectID added successfully";
        } else {
            echo "Error: " . $projectCourseQuery . "<br>" . $connection->error;
        }
    }

	if ($result = mysqli_query($connection, $query)) {
	    echo "Project: $projectTitle added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

    unlink('/var/www/html/projects/'.$projectID.'.php');

    copy('/var/www/html/projectTemplate.php', ('/var/www/html/projects/'.$projectID.'.php'));

	header("Refresh:2; url=../admin/supervisor/editproject.php");

    $connection->close();

?>
