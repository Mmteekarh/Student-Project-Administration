<!-- Script for adding a project to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

	$projectTitle = $_POST['projectTitle'];
	$supervisorID = $_POST['supervisorID'];
    $courses = $_POST['courses'];
    $projectID = getNextID($connection);
    $projectBrief = $_POST['projectBrief'];
    $maximumStudents = $_POST['maximumStudents'];
    $projectCode = $_POST['projectCode'];

	$projectQuery = "INSERT INTO project (projectID, projectTitle, supervisorID, projectBrief, maximumStudents, projectCode, dateCreated, lastUpdated)
	VALUES ('$projectID', '$projectTitle', '$supervisorID', '$projectBrief', '$maximumStudents', '$projectCode', now(), now())";

    foreach($courses as $item) {
        $projectCourseQuery = "INSERT INTO projectCourse (projectID, courseID) VALUES ('$projectID','$item')";

        if ($connection->query($projectCourseQuery) === TRUE) {
            echo "Course Pair: $item : $projectID added successfully";
        } else {
            echo "Error: " . $projectCourseQuery . "<br>" . $connection->error;
        }
    }

	if ($connection->query($projectQuery) === TRUE) {
	    echo "Project: $projectTitle added successfully";
	} else {
	    echo "Error: " . $query . "<br>" . $connection->error;
	}

    copy('/var/www/html/projectTemplate.php', ('/var/www/html/projects/' . $projectID . '.php'));

	header("Refresh:2; url=../admin/supervisor.php");

    function getNextID($connection) {
        $projectID = "";
        
        $query = "SELECT COUNT(*) AS total FROM project";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $projectID = $row["total"] + 1;
            }
        } else {
            echo "Error: " . $query . "<br>" . $connection->error;
        }

        return $projectID;
    }

    $connection->close();

?>