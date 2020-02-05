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

                <form name="addProjectForm" action="../../php/addProject.php" method="POST" enctype="multipart/form-data">

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
                                    echo "Error: No records found in the table!";
                                }

                                // Closes connection.
                                $connection->close();
                            ?>  
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="addButton">Add</button>

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