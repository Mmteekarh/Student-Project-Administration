<!-- Page for editing a project -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/connect.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Editing Project - SPAS</title>

       <?php

            $projectID = $_POST["projectID"];

            // Gets project details of the project being edited.
            $projectQuery = "SELECT * FROM project WHERE projectID='$projectID'";
            $projectResult = $connection->query($projectQuery);

            if ($projectResult->num_rows > 0) {
                while($projectRow = $projectResult->fetch_assoc()) {
                    $projectTitle = $projectRow["projectTitle"];
                    $projectBrief = $projectRow["projectBrief"];
                    $projectCode = $projectRow["projectCode"];
                    $maximumStudents = $projectRow["maximumStudents"];
                }
            }

        ?>

</head>

<body>

    <!-- Ensures supervisor or admin are logged in before displaying the page -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/supervisornav.php" ?>

    <!-- Page content includes edit form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Editing Project</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../supervisor.php">Supervisor Tools</a>
            </li>
            <li class="breadcrumb-item active">Editing Project</li>
        </ol>

        <!-- Editing Project Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <h3>Editing Project</h3>

                <!-- Displays the project form with a default value in each field from the current value in the database -->
                <form name="editProjectForm" action="../../php/editProject.php" method="POST" enctype="multipart/form-data">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Title</label>
                            <input type="text" class="form-control" name="projectTitle" value="<?php echo $projectTitle; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Brief</label>
                            <textarea rows="10" cols="100" class="form-control" name="projectBrief" required maxlength="999" style="resize:none"><?php echo $projectBrief; ?></textarea>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Maximum Students</label>
                            <input type="text" class="form-control" name="maximumStudents" value="<?php echo $maximumStudents; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Project Code</label>
                            <input type="text" class="form-control" name="projectCode" value="<?php echo $projectCode; ?>" required>
                        </div>
                    </div>

                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                  
                    <div class="control-group form-group">
                        <div class="controls">

                            <?php

                                // Gets the list of courses and gives each one a checkbox.
                                $courseQuery = "SELECT * FROM course";
                                $courseResult = $connection->query($courseQuery);

                                if ($courseResult->num_rows > 0) {
                                    while($courseRow = $courseResult->fetch_assoc()) {
                                        $courseName = $courseRow['courseName'];
                                        $courseID = $courseRow['courseID'];

                                        echo '<div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="checkbox" name="courses[]" value="'.$courseID.'">
                                                  <label class="form-check-label" for="courses[]">'.$courseName.'</label>
                                              </div>';
                                    }
                                } else {
                                    echo "Error: No records found in the table!";
                                }

                                $connection->close();

                            ?>  
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="editButton">Edit</button>

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