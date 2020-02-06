<!-- Script adds a selected project to the database -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

	$projectID = $_POST['projectID'];
	$studentID = $_POST['studentID'];
	$choiceNumber = $_POST['choiceNumber'];

	$studentQuery = "SELECT * FROM student WHERE studentID='$studentID'";
    $studentResult = $connection->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        while($studentRow = $studentResult->fetch_assoc()) {
            $firstChoice = $studentRow["projectFirstChoice"];
            $secondChoice = $studentRow["projectSecondChoice"];
            $thirdChoice = $studentRow["projectThirdChoice"];
        }
    } else {
        echo "Error: No records found in table!";
    }

    if ($choiceNumber == "1") {

        // Checks if the user has already selected the project.
		if ($secondChoice == $projectID or $thirdChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {

	    	$firstChoiceQuery = "UPDATE student SET projectFirstChoice = '$projectID' WHERE studentID = '$studentID'";

			if ($connection->query($firstChoiceQuery) === TRUE) {
				echo "Successfully added $projectID as first choice selection!";
			} else {
				echo "Error: No records found in table!";
			}
		}

    } else if ($choiceNumber == "2") {
        
        // Checks if the user has already selected the project.
    	if ($firstChoice == $projectID or $thirdChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {
	    	$secondChoiceQuery = "UPDATE student SET projectSecondChoice='$projectID' WHERE studentID='$studentID'";

	    	if ($connection->query($secondChoiceQuery) === TRUE) {
				echo "Successfully added $projectID as second choice selection!";
			} else {
				echo "Error: " . $secondChoiceQuery . "<br>" . $connection->error;
			}
		}

    } else if ($choiceNumber == "3") {

        // Checks if the user has already selected the project.
    	if ($secondChoice == $projectID or $firstChoice == $projectID) {
    		echo "You have already selected this project!";

    	} else {
	    	$thirdChoiceQuery = "UPDATE student SET projectThirdChoice='$projectID' WHERE studentID='$studentID'";

	    	if ($connection->query($thirdChoiceQuery) === TRUE) {
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
