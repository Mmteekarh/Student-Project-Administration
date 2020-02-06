<!-- Script used to remove a deadline -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $deadlineID = $_POST['deadlineID'];

    $query = "DELETE FROM deadlines WHERE deadlineID='$deadlineID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../admin/systemmanagement/deadlines.php");

?>