<!-- Page includes a form for a supervisor to add a project -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/connect.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Add Project - SPAS</title>

</head>

<body>

    <!-- Check if the user is logged in and are a supervisor or admin -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/supervisornav.php" ?>


    <!-- Script for adding a project to the database -->
    <?php

        function getNextID($connection) {
            $projectID = "";
            
            $query = "SELECT COUNT(*) AS total FROM project";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $projectID = $row["total"] + 1;
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                        Error: Could not retrieve projects! Please contact an administrator.
                      </div>';
            }

            return $projectID;
        }

        $projectTitle = $supervisorID = $courses = $projectID = $projectBrief = $maximumStudents = $projectCode = "";

        if (isset($_POST['submit'])) {
            $projectTitle = $_POST['projectTitle'];
            $supervisorID = $_POST['supervisorID'];
            $courses = $_POST['courses'];
            $projectID = getNextID($connection);
            $projectBrief = $_POST['projectBrief'];
            $maximumStudents = $_POST['maximumStudents'];
            $projectCode = $_POST['projectCode'];

            // Form validation
            if (!(is_numeric($maximumStudents))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Maximum students must be a number!
                      </div>';

            } else if ($maximumStudents > 1000 or $maximumStudents < 1) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Maximum students must be between 1 and 1000!
                      </div>';

            } else if (strlen($projectTitle) > 250) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Project title is too long!
                      </div>';

            } else if (strlen($projectCode) > 50) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Project code is too long!
                      </div>';

            } else if (empty($courses)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Please select at least one course!
                      </div>';

            } else {

                $projectQuery = "INSERT INTO project (projectID, projectTitle, supervisorID, projectBrief, maximumStudents, projectCode, dateCreated, lastUpdated)
                VALUES ('$projectID', '$projectTitle', '$supervisorID', '$projectBrief', '$maximumStudents', '$projectCode', now(), now())";

                foreach($courses as $item) {
                    $projectCourseQuery = "INSERT INTO projectCourse (projectID, courseID) VALUES ('$projectID','$item')";

                    if ($connection->query($projectCourseQuery) === TRUE) {
                        continue;
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                                    Error: Could not insert project-course match! Please contact an administrator.
                              </div>';
                    }
                }

                if ($connection->query($projectQuery) === TRUE) {
                    // Create new project file and refresh to supervisor page.
                    copy('/var/www/html/projectTemplate.php', ('/var/www/html/projects/' . $projectID . '.php'));
                    header("Refresh:0.01; url=../supervisor.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not insert project! Please contact an administrator.
                          </div>'; 
                }
            }
        }

    ?>

    <!-- Page content includes an add project form. -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">Add Project</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../supervisor.php">Supervisor Tools</a>
            </li>
            <li class="breadcrumb-item active">Add Project</li>
        </ol>

        <!-- Add Project Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="addProjectForm" action="addproject.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="supervisorID" value="<?php echo $loggedInSupervisorID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Title</label>
                            <input type="text" class="form-control" name="projectTitle" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Brief</label>
                            <textarea rows="10" cols="100" class="form-control" name="projectBrief" required maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Maximum Students</label>
                            <input type="text" class="form-control" name="maximumStudents" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Code</label>
                            <input type="text" class="form-control" name="projectCode" required>
                        </div>
                    </div>
              
                    <div class="control-group form-group">
                        <div class="controls">
                            <?php

                                // Query to get the list of courses, used in a checkbox style.
                                $query = "SELECT * FROM course";
                                $result = $connection->query($query);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $courseName = $row['courseName'];
                                        $courseID = $row['courseID'];

                                        // Gives each course a checkbox.
                                        echo '<div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="checkbox" name="courses[]" value="' . $courseID . '">
                                                  <label class="form-check-label" for="courses[]">' . $courseName . '</label>
                                              </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">
                                                Error: We could not load the course data! Please contact an administrator. 
                                          </div>';
                                }

                                $connection->close();

                            ?>  
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit" id="addButton">Add</button>

                </form>

            </div>

        </div>

    </div>

    <?php include "../../includes/footer.php" ?>

    <?php
        
            } else if ($userType == "student") {
                // Invalid Permissions
                header("Refresh:0.01; url=../../error/permissionerror.php");

            } else {
                // Invalid user type
                header("Refresh:0.01; url=../../error/usertypeerror.php");
            }
        } else {
            header("Refresh:0.01; url=../../login.php");
        }
    ?>

</body>

</html>
