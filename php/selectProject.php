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

	$projectID = $_POST['projectID'];
	$studentID = $_POST['studentID'];
	$choiceNumber = $_POST['choiceNumber'];

	$query = "SELECT * FROM student";

	if ($result = mysqli_query($connection, $query)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                $firstChoice = $row["projectFirstChoice"];
                $secondChoice = $row["projectSecondChoice"];
                $thirdChoice = $row["projectThirdChoice"];
            }
        }
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }

    if ($choiceNumber == "1") {
		if ($secondChoice == $projectID or $thirdChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {
	    	$firstChoiceQuery = "UPDATE student SET projectFirstChoice='$projectID' WHERE studentID='$studentID'";

			if ($result = mysqli_query($connection, $firstChoiceQuery)) {
				echo "Successfully added $projectID as first choice selection!";
			} else {
				echo "Error: " . $firstChoiceQuery . "<br>" . $connection->error;
			}
		}

    } else if ($choiceNumber == "2") {
    	if ($firstChoice == $projectID or $thirdChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {
	    	$secondChoiceQuery = "UPDATE student SET projectSecondChoice='$projectID' WHERE studentID='$studentID'";

	    	if ($result = mysqli_query($connection, $secondChoiceQuery)) {
				echo "Successfully added $projectID as second choice selection!";
			} else {
				echo "Error: " . $secondChoiceQuery . "<br>" . $connection->error;
			}
		}


    } else if ($choiceNumber == "3") {
    	if ($secondChoice == $projectID or $firstChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {
	    	$thirdChoiceQuery = "UPDATE student SET projectThirdChoice='$projectID' WHERE studentID='$studentID'";

	    	if ($result = mysqli_query($connection, $thirdChoiceQuery)) {
				echo "Successfully added $projectID as third choice selection!";
			} else {
				echo "Error: " . $thirdChoiceQuery . "<br>" . $connection->error;
			}
		}

    } else {
    	echo "You are at the maximum amount of selected projects, please remove one before adding another!";
    }

	header("Refresh:2; url=../projects/".$projectID.".php");

    $connection->close();

?>
