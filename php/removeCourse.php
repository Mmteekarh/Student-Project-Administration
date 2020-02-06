<!-- Script used to remove a course -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $courseID = $_POST['courseID'];

    $query = "DELETE FROM course WHERE courseID='$courseID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../admin/systemmanagement/courselist.php");

?>