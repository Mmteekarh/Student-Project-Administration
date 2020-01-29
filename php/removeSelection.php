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

    $studentID = $_POST['studentID'];
    $choiceNumber = $_POST['choiceNumber'];
    $selectionRow;

    if ($choiceNumber == '1') {
        $selectionRow = "projectFirstChoice";
    } else if ($choiceNumber == '2') {
        $selectionRow = "projectSecondChoice";
    } else if ($choiceNumber == '3') {
        $selectionRow = "projectThirdChoice";
    } else {
        $selectionRow = "";
    }

    $query = "UPDATE student SET $selectionRow = NULL WHERE studentID='$studentID'";

    if ($connection->query($query) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

	$connection->close();

	header("Refresh:2; url=../selection.php");

?>