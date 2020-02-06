<!-- Script that removes a selected project from a users selection -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $studentID = $_POST['studentID'];
    $choiceNumber = $_POST['choiceNumber'];

    if ($choiceNumber == '1') {
        $selectionRow = "projectFirstChoice";
    } else if ($choiceNumber == '2') {
        $selectionRow = "projectSecondChoice";
    } else if ($choiceNumber == '3') {
        $selectionRow = "projectThirdChoice";
    } else {
        $selectionRow = "";
    }

    $query = "UPDATE student SET $selectionRow = NULL WHERE studentID = '$studentID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../selection.php");

?>