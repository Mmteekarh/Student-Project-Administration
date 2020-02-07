<!-- Script allocates projects to students -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    //for all students in table
    	// if student has not selected 3 choices
    		// put in manual queue
    	// for all student first choice
    		// if super limit reached
    			// skip
    		// else if project limit reached
    			// skip
    		// else
    			// assign first choice to student
    			// assign random marker to student
    	// for all student second choice
    		// if super limit reached
    			// skip
    		// else if project limit reached
    			// skip
    		// else
    			// assign second choice to student
    			// assign random marker to student
    	// for all student third choice
    		// if super limit reached
    			// skip
    		// else if project limit reached
    			// skip
    		// else
    			// assign third choice to student
    			// assign random marker to student

    $manualQueue = array();
    $studentsAllocated = array();
    $projectsAllocated = array();
    $supervisorsAllocated = array();

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
		        	$projectID = $firstChoiceRow["projectFirstChoice"];
		        	$supervisorID = $firstChoiceRow["supervisorID"];
		        	$supervisorMax = $firstChoiceRow["maxStudents"];
		        	$projectMax = $firstChoiceRow["maximumStudents"];

		        	// If supervisor max students and project max students reached, skip
		        	if ($supervisorsAllocated[$supervisorID] == $supervisorMax OR $projectsAllocated[$projectID] == $projectMax) {
		        		
		        		$secondChoiceQuery = "SELECT * FROM student 
        					INNER JOIN project ON student.projectSecondChoice = project.projectID
        					INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID
        					WHERE studentID = '$studentID'";
					    $secondChoiceResult = $connection->query($secondChoiceQuery);

					    if ($secondChoiceResult->num_rows > 0) {
					        while($secondChoiceRow = $secondChoiceResult->fetch_assoc()) {
					        	$projectID = $secondChoiceRow["projectSecondChoice"];
					        	$supervisorID = $secondChoiceRow["supervisorID"];
					        	$supervisorMax = $secondChoiceRow["maxStudents"];
					        	$projectMax = $secondChoiceRow["maximumStudents"];

					        	// If supervisor max students and project max students reached, skip
					        	if ($supervisorsAllocated[$supervisorID] == $supervisorMax or $projectsAllocated[$projectID] == $projectMax) {

					        		$thirdChoiceQuery = "SELECT * FROM student 
						            					INNER JOIN project ON student.projectThirdChoice = project.projectID
						            					INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID
						            					WHERE studentID = '$studentID'";
								    $thirdChoiceResult = $connection->query($thirdChoiceQuery);

								    if ($thirdChoiceResult->num_rows > 0) {
								        while($thirdChoiceRow = $thirdChoiceResult->fetch_assoc()) {
								        	$projectID = $thirdChoiceRow["projectThirdChoice"];
								        	$supervisorID = $thirdChoiceRow["supervisorID"];
								        	$supervisorMax = $thirdChoiceRow["maxStudents"];
								        	$projectMax = $thirdChoiceRow["maximumStudents"];

								        	// If supervisor max students and project max students reached, skip
								        	if ($supervisorsAllocated[$supervisorID] == $supervisorMax or $projectsAllocated[$projectID] == $projectMax) {
								        		continue 2;
								        	} else {
								        		// Assign user third choice
								        		$projectsAllocated[$projectID] = $projectsAllocated[$projectID] + 1;
								        		$supervisorsAllocated[$supervisorID] = $supervisorsAllocated[$supervisorID] + 1;

								        		$confirmedQuery = "UPDATE student SET projectID = '$projectID' WHERE studentID = '$studentID'";

												if ($connection->query($confirmedQuery) === TRUE) {
													break 2;
												} else {
												    echo "Error: " . $confirmedQuery . "<br>" . $connection->error;
												}

								        	}
								        }
								    } else {
								        echo "Error: No records found in table!";
								    }
					        	
					        	} else {
					        		// Assign user second choice
					        		$projectsAllocated[$projectID] = $projectsAllocated[$projectID] + 1;
					        		$supervisorsAllocated[$supervisorID] = $supervisorsAllocated[$supervisorID] + 1;

					        		$confirmedQuery = "UPDATE student SET projectID = '$projectID' WHERE studentID = '$studentID'";

									if ($connection->query($confirmedQuery) === TRUE) {
										continue 2;
										echo "second choice true";
									} else {
									    echo "Error: " . $confirmedQuery . "<br>" . $connection->error;
									}

					        	}
					        }
					    } else {
					        echo "Error: No records found in table!";
					    }

		        	} else {
		        		// Assign user first choice
		        		$projectsAllocated[$projectID] = $projectsAllocated[$projectID] + 1;
		        		$supervisorsAllocated[$supervisorID] = $supervisorsAllocated[$supervisorID] + 1;

		        		$confirmedQuery = "UPDATE student SET projectID = '$projectID' WHERE studentID = '$studentID'";

						if ($connection->query($confirmedQuery) === TRUE) {
							continue;
							echo "first choice true";
						} else {
						    echo "Error: " . $confirmedQuery . "<br>" . $connection->error;
						}

		        	}
		        }
		    } else {
		        echo "Error: No records found in table!";
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

    $connection->close();

?>
