<!-- Page is a template for all project pages, page gets copied on project creation -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../includes/connect.php" ?>
    <?php include "../includes/header.php" ?>
    <?php include "../includes/userscript.php" ?>

    <?php

        // Gets the project id from the current file name and assigns empty variables for use later.
        $projectID = basename(__FILE__, '.php');

        // Query to get the project data based on the ID.
        $query = "SELECT * FROM project where projectID='$projectID'";
        $result = $connection->query($query);

        // Gets all data and assigns to variables.
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $projectTitle = $row["projectTitle"];
                $projectBrief = $row["projectBrief"];
                $projectCode = $row["projectCode"];

                $supervisorRow = getSupervisorDetails($connection, $row["supervisorID"]);

                $supervisorOffice = $supervisorRow['officeNumber'];
                $supervisorEmail = $supervisorRow['emailAddress'];

                $supervisorTitle = $supervisorRow['supervisorTitle'];
                $supervisorFirstName = $supervisorRow['firstName'];
                $supervisorLastName = $supervisorRow['lastName'];
                $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;
            }
        }


        // Function uses the ID to get the supervisor name from the supervisor table.
        function getSupervisorDetails($connection, $supervisorID) {

            $query = "SELECT * FROM supervisor WHERE supervisorID='$supervisorID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row;
                }
            } else {
                echo "Error: No records found in the table!";
            }

            return $row;
        }

        // Function used to get courses which are relevant to the project.
        function getRelevantCourses($connection, $projectID) {

            $courses = array();

            // Query joins projectCourse and course tables to get course details specific to the current project.
            $query = "SELECT * FROM projectCourse INNER JOIN course ON projectCourse.courseID = course.courseID WHERE projectCourse.projectID = '$projectID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $courseName = $row['courseName'];
                    array_push($courses,$courseName);
                }
            } else {
                echo "Error: No records found in the table!";
            }

            return $courses;
        }

        // Gets relevant courses specific to the project selected.
        $relevantCourses = getRelevantCourses($connection, $projectID);

    ?>

    <!-- Sets title to project title -->
    <title><?php echo $projectTitle; ?> - SPAS</title>

</head>

<body>

    <!-- Includes main navbar -->
    <?php include "../includes/mainnav.php" ?>

    <!-- Main Page Content -->
    <div class="container">

        <!-- Page Heading and breadcrumbs -->
        <h1 class="mt-4 mb-3"><?php echo $projectTitle; ?></h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../index.php">Project List</a>
            </li>
            <li class="breadcrumb-item active">
                <?php echo $projectTitle; ?>
            </li>
        </ol>

        <!-- First row contains two columns - project and supervisor info -->
        <div class="row">

            <!-- Left row of content - shows project info: title, supervisor, course, project code -->
            <div class="col-md-6 border">

                <br>

                <p><b>Title: </b><?php echo $projectTitle; ?></p><br>
                <p><b>Supervisor: </b><?php echo $supervisorName; ?></p><br>
                <p><b>Relevant Courses:</b>
                <?php
                    // Loops through each course in the loop and prints out the course.
                    $i = 0;
                    $len = count($relevantCourses);
                    foreach ($relevantCourses as $course) {
                        if ($i==$len-1) {
                            echo $course;
                        } else {
                            echo $course . ", "; 
                        }
                        $i++;
                    } 
                ?> 
                </p>

                <br>

                <p><b>Project Code: </b><?php echo $projectCode; ?></p>

                <!-- Checks if user is logged in as a student, if so, display select project buttons -->
    			<?php
                    if ($loggedIn == true) {
    	                if ($userType == "student") {
    	        ?>

                <!-- Each button posts to the same php script and a hidden value posts the choice number -->
                <form action="../php/selectProject.php" method="POST" role="form">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="studentID" value="<?php echo $loggedInStudentID; ?>">
                    <input type="hidden" name="choiceNumber" value="1">
                    <center><button type="submit" class="btn btn-success">Select First Choice</button></center>
                </form>

                <br>

                <form action="../php/selectProject.php" method="POST" role="form">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="studentID" value="<?php echo $loggedInStudentID; ?>">
                    <input type="hidden" name="choiceNumber" value="2">
                    <center><button type="submit" class="btn btn-success">Select Second Choice</button></center>
                </form>

                <br>

                <form action="../php/selectProject.php" method="POST" role="form">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="studentID" value="<?php echo $loggedInStudentID; ?>">
                    <input type="hidden" name="choiceNumber" value="3">
                    <center><button type="submit" class="btn btn-success">Select Third Choice</button></center>
                </form>

                <br>

                <?php 
    	            	}
    	            }
                ?>

            </div>

            <br><hr><br>

            <!-- Right row of content - shows supervisor details -->
            <div class="col-md-6 border">

                <br>

                <h4>Supervisor Information</h4>

                <br>

                <p><b>Name: </b><?php echo $supervisorName; ?></p><br>
                <p><b>Office: </b><?php echo $supervisorOffice; ?></p><br>
                <p><b>Email Address: </b><?php echo $supervisorEmail; ?></p>

            </div>

        </div>

        <!-- Creates a line below the two sections -->
        <br>
        <hr>
        <br>

        <!-- Bottom row of content - shows project brief -->
        <div class="row">

            <div class="col-md-12 border">

                <br>

                <center>
                    <h4>Project Brief</h4>
                </center>

                <br>

                <!-- Project brief uses wordwrap function in order to keep the text on the screen -->
                <p><?php echo wordwrap($projectBrief, 200, "<br>", true); ?>

                <br>

            </div>

        </div>

        <br>
        <br>

    </div>

    <!-- Closes connection -->
    <?php $connection->close(); ?>

    <!-- Includes footer -->
    <?php include "../includes/footer.php" ?>

</body>

</html>