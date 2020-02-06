<!-- Script used to remove a project -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $projectID = $_POST['projectID'];

    $projectQuery = "DELETE FROM project WHERE projectID = '$projectID'";

    if ($connection->query($projectQuery) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $projectQuery . "<br>" . $connection->error;
    }

    $projectCourseQuery = "DELETE FROM projectCourse WHERE projectID = '$projectID'";

    if ($connection->query($projectCourseQuery) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $projectCourseQuery . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../admin/supervisor.php");

?>