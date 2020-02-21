<!-- Script allocates projects to students -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $manualQueue = array();
    $projectsAllocated = array();
    $supervisorsAllocated = array();

    // Main allocation outer loop
	$studentQuery = "SELECT * FROM student";
    $studentResult = $connection->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        while($studentRow = $studentResult->fetch_assoc()) {
        	$studentID = $studentRow["studentID"];
        	$projectFirstChoice = $studentRow["projectFirstChoice"];
        	$projectSecondChoice = $studentRow["projectSecondChoice"];
        	$projectThirdChoice = $studentRow["projectThirdChoice"];

        	if (is_null($projectFirstChoice) or is_null($projectSecondChoice) or is_null($projectThirdChoice)) {
        		array_push($manualQueue, $studentID);
        		continue;
        	}

            $firstChoiceQuery = "SELECT * FROM student 
            					 INNER JOIN project ON student.projectFirstChoice = project.projectID
            					 INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID
            					 WHERE studentID = '$studentID'";
		    $firstChoiceResult = $connection->query($firstChoiceQuery);

		    if ($firstChoiceResult->num_rows > 0) {
		        while($firstChoiceRow = $firstChoiceResult->fetch_assoc()) {
		        	$firstProjectID = $firstChoiceRow["projectFirstChoice"];
		        	$firstSupervisorID = $firstChoiceRow["supervisorID"];
		        	$firstSupervisorMax = $firstChoiceRow["maxStudents"];
		        	$firstProjectMax = $firstChoiceRow["maximumStudents"];

		        	if (!(array_key_exists($projectID, $projectsAllocated)) OR !(array_key_exists($supervisorID, $supervisorsAllocated))) {
        				// Assign first choice
		        		assignChoice($connection, $studentID, $firstProjectID, $firstSupervisorID);
		        		break;
        			}	

		        	// If supervisor max students and project max students reached, skip to second choice
		        	if ($supervisorsAllocated['$firstSupervisorID'] >= $firstSupervisorMax OR $projectsAllocated['$firstProjectID'] >= $firstProjectMax) {
		        		
		        		$secondChoiceQuery = "SELECT * FROM student 
        									  INNER JOIN project ON student.projectSecondChoice = project.projectID
        									  INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID
        									  WHERE studentID = '$studentID'";
					    $secondChoiceResult = $connection->query($secondChoiceQuery);

					    if ($secondChoiceResult->num_rows > 0) {
					        while($secondChoiceRow = $secondChoiceResult->fetch_assoc()) {
					        	$secondProjectID = $secondChoiceRow["projectSecondChoice"];
					        	$secondSupervisorID = $secondChoiceRow["supervisorID"];
					        	$secondSupervisorMax = $secondChoiceRow["maxStudents"];
					        	$secondProjectMax = $secondChoiceRow["maximumStudents"];

					        	// If supervisor max students and project max students reached, skip to third choice
					        	if ($supervisorsAllocated['$secondSupervisorID'] >= $secondSupervisorMax OR $projectsAllocated['$secondProjectID'] >= $secondProjectMax) {

					        		$thirdChoiceQuery = "SELECT * FROM student 
						            					 INNER JOIN project ON student.projectThirdChoice = project.projectID
						            					 INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID
						            					 WHERE studentID = '$studentID'";
								    $thirdChoiceResult = $connection->query($thirdChoiceQuery);

								    if ($thirdChoiceResult->num_rows > 0) {
								        while($thirdChoiceRow = $thirdChoiceResult->fetch_assoc()) {
								        	$thirdProjectID = $thirdChoiceRow["projectThirdChoice"];
								        	$thirdSupervisorID = $thirdChoiceRow["supervisorID"];
								        	$thirdSupervisorMax = $thirdChoiceRow["maxStudents"];
								        	$thirdProjectMax = $thirdChoiceRow["maximumStudents"];

								        	// If supervisor max students and project max students reached, skip
								        	if ($supervisorsAllocated['$thirdSupervisorID'] >= $thirdSupervisorMax OR $projectsAllocated['$thirdProjectID'] >= $thirdProjectMax) {
								        		continue 2;
								        	} else {
								        		// Assign third choice
		        								assignChoice($connection, $studentID, $thirdProjectID, $thirdSupervisorID);

								        	}
								        }
								    } else {
								        echo "Error: user does not have a third choice!";
								    }
					        	
					        	} else {
					        		// Assign second choice
		        					assignChoice($connection, $studentID, $secondProjectID, $secondSupervisorID);

					        	}
					        }
					    } else {
					        echo "Error: user does not have a second choice!";
					    }

		        	} else {
		        		// Assign first choice
		        		assignChoice($connection, $studentID, $firstProjectID, $firstSupervisorID);
		        	}
		        }
		    } else {
		        echo "Error: user does not have a first choice!";
		    }

		}
	} else {
		echo "Error: No records found in table!";
	}

	$managementUpdate = "UPDATE management SET projectsAllocated = 1";

	if ($connection->query($managementUpdate) === TRUE) {
		// Redirect to system management.
		header("Refresh:0.01; url=../admin/systemmanagement.php");
	} else {
	    echo "Error: " . $managementUpdate . "<br>" . $connection->error;
	}

	header("Refresh:1; url=../admin/systemmanagement.php");

    function getRandomMarker($connection, $supervisorID) {
    	$secondMarkerQuery = "SELECT * FROM supervisor WHERE supervisorID NOT IN (0) ORDER BY RAND() LIMIT 1";
		$secondMarkerResult = $connection->query($secondMarkerQuery);

	    if ($secondMarkerResult->num_rows > 0) {
	        while($secondMarkerRow = $secondMarkerResult->fetch_assoc()) {
	        	$randomSupervisor = $secondMarkerRow["supervisorID"];

	        	if ($randomSupervisor == $supervisorID OR $randomSupervisor == '0') {
	        		getRandomMarker($connection, $supervisorID);
	        	} else {
	        		return $randomSupervisor;
	        	}
	        }
	    }
    }

    function assignChoice($connection, $studentID, $projectID, $supervisorID) {

		// Assign choice to user
		if (!(array_key_exists($projectID, $projectsAllocated))) {
			$projectsAllocated['$projectID'] = 1;
		} else {
			$projectsAllocated['$projectID'] = ($projectsAllocated['$projectID'] + 1);
		}
		if (!(array_key_exists($supervisorID, $supervisorsAllocated))) {
			$supervisorsAllocated['$supervisorID'] = 1;
		} else {
			$supervisorsAllocated['$supervisorID'] = ($supervisorsAllocated['$supervisorID'] + 1);
		}

		$randomSupervisor = getRandomMarker($connection, $supervisorID);

		$confirmedQuery = "UPDATE student SET secondMarker = '$randomSupervisor', projectID = '$projectID' WHERE studentID = '$studentID'";

		if (!($connection->query($confirmedQuery) === TRUE)) {
		    echo "Error: " . $confirmedQuery . "<br>" . $connection->error;
		}

    }

    $connection->close();
?>
