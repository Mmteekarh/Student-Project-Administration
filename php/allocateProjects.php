<!-- Script allocates projects to students -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $manualQueue = array();
    $studentsAllocated = array();
    $projectsAllocated = array();
    $supervisorsAllocated = array();

    // Populate arrays with keys
    $supervisorQuery = "SELECT * FROM supervisor";
    $supervisorResult = $connection->query($supervisorQuery);

    if ($supervisorResult->num_rows > 0) {
        while($supervisorRow = $supervisorResult->fetch_assoc()) {
        	$sid = $supervisorRow["supervisorID"];
        	array_push($supervisorsAllocated, $sid);
        }
    }

    $projectQuery = "SELECT * FROM project";
    $projectResult = $connection->query($projectQuery);

    if ($projectResult->num_rows > 0) {
        while($projectRow = $projectResult->fetch_assoc()) {
        	$pid = $projectRow["projectID"];
        	array_push($projectsAllocated, $pid);
        }
    }

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

		        	// If supervisor max students and project max students reached, skip to second choice
		        	if ($supervisorsAllocated[$firstSupervisorID] == $firstSupervisorMax OR $projectsAllocated[$firstProjectID] == $firstProjectMax) {
		        		
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
					        	if ($supervisorsAllocated[$secondSupervisorID] == $secondSupervisorMax or $projectsAllocated[$secondProjectID] == $secondProjectMax) {

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
								        	if ($supervisorsAllocated[$thirdSupervisorID] == $thirdSupervisorMax or $projectsAllocated[$thirdProjectID] == $thirdProjectMax) {
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
		echo "Updated management table";
	} else {
	    echo "Error: " . $managementUpdate . "<br>" . $connection->error;
	}

	header("Refresh:1; url=../admin/systemmanagement.php");

    function getRandomMarker($connection, $supervisorID) {
    	$secondMarkerQuery = "SELECT COUNT(*) AS total FROM supervisor";
		$secondMarkerResult = $connection->query($secondMarkerQuery);

		$randomSupervisor = 0;

	    if ($secondMarkerResult->num_rows > 0) {
	        while($secondMarkerRow = $secondMarkerResult->fetch_assoc()) {
	        	$totalSupervisors = $secondMarkerRow["total"];

	        	$randomSupervisor = rand(1, $totalSupervisors);

	        	if ($randomSupervisor == $supervisorID) {
	        		getRandomMarker($connection, $supervisorID);
	        	} else {
	        		return $randomSupervisor;
	        	}
	        }
	    }
    }

    function assignChoice($connection, $studentID, $projectID, $supervisorID) {

		// Assign choice to user
		$projectsAllocated[$projectID] = $projectsAllocated[$projectID] + 1;
		$supervisorsAllocated[$supervisorID] = $supervisorsAllocated[$supervisorID] + 1;

		$randomSupervisor = getRandomMarker($connection, $supervisorID);

		$confirmedQuery = "UPDATE student SET secondMarker = '$randomSupervisor', projectID = '$projectID' WHERE studentID = '$studentID'";

		if (!($connection->query($confirmedQuery) === TRUE)) {
		    echo "Error: " . $confirmedQuery . "<br>" . $connection->error;
		}

    }

    $connection->close();
?>
