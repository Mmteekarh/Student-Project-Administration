<!-- Script that removes supervisor from the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $supervisorID = $_POST['supervisorID'];

    $query = "DELETE FROM supervisor WHERE supervisorID = '$supervisorID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../admin/systemmanagement/supervisorlist.php");

?>