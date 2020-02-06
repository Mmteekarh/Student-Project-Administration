<!-- Script used to edit project -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

	$projectTitle = $_POST['projectTitle'];
    $courses = $_POST['courses'];
    $projectID = $_POST['projectID'];
    $projectBrief = $_POST['projectBrief'];
    $maximumStudents = $_POST['maximumStudents'];
    $projectCode = $_POST['projectCode'];

	$projectQuery = "UPDATE project SET projectTitle = '$projectTitle', projectBrief = '$projectBrief', maximumStudents = '$maximumStudents', projectCode = '$projectCode', lastUpdated = now() WHERE projectID='$projectID'";
    $removeProjectCourseQuery = "DELETE FROM projectCourse WHERE projectID='$projectID'";

    // Removes project-course links.
    if ($connection->query($removeProjectCourseQuery) === TRUE) {
        echo "Course Pair: $projectID removed successfully";
    } else {
        echo "Error: " . $removeProjectCourseQuery . "<br>" . $connection->error;
    }

    // Insert records to project-course table based on what courses are related.
    foreach($courses as $item) {

        $projectCourseQuery = "INSERT INTO projectCourse (projectID, courseID) VALUES ('$projectID','$item')";

        if ($connection->query($projectCourseQuery) === TRUE) {
            echo "Course Pair: $item : $projectID added successfully";
        } else {
            echo "Error: " . $projectCourseQuery . "<br>" . $connection->error;
        }

    }

    // Add project to database.
	if ($connection->query($projectQuery) === TRUE) {
	    echo "Project: $projectTitle added successfully";
	} else {
	    echo "Error: " . $projectQuery . "<br>" . $connection->error;
	}

    // Remove project file.
    unlink('/var/www/html/projects/' . $projectID . '.php');

    // Create new project file.
    copy('/var/www/html/projectTemplate.php', ('/var/www/html/projects/' . $projectID . '.php'));

	header("Refresh:2; url=../admin/supervisor.php");

    $connection->close();

?>
