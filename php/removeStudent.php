<!-- Script that removes students from the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $studentID = $_POST['studentID'];

    $query = "DELETE FROM student WHERE studentID='$studentID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

?>