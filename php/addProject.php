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
    $projectID = getNextID($connection);
    $projectBrief = $_POST['projectBrief'];
    $maximumStudents = $_POST['maximumStudents'];
    $projectCode = $_POST['projectCode'];


	$query = "INSERT INTO project (projectID, projectTitle, supervisorID, projectBrief, maximumStudents, projectCode, dateAdded, lastEdited)
	VALUES ('$projectID', '$projectTitle', '$supervisorID', '$projectBrief', '$maximumStudents', '$projectCode', now(), now())";

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

    copy('/var/www/html/projectTemplate.php', ('/var/www/html/projects/'.$projectID.'.php'));

	header("Refresh:2; url=../admin/addproject.php");

    function getNextID($connection) {
        $projectID = "";
        
        $query = "SELECT COUNT(*) AS total FROM project";

        if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $projectID = $row["total"] + 1;
                }
            }
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }

        return $projectID;
    }

    $connection->close();

?>