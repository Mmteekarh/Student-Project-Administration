<!-- Page contains form for adding courses. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Add Course - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script for adding a course to the database -->
    <?php

        $courseID = $courseName = $courseLevel = $courseLeader = "";

        if (isset($_POST['submit'])) {

            $courseID = $_POST['courseID'];
            $courseName = $_POST['courseName'];
            $courseLevel = $_POST['courseLevel'];
            $courseLeader = $_POST['courseLeader'];

            // Form validation
            if (!(is_numeric($courseLevel))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Course level must be a number!
                      </div>';

            } else if (strlen($courseLeader) > 250) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Course leader name is too long!
                      </div>';

            } else if (strlen($courseName) > 50) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Course name is too long!
                      </div>';

            } else if (!(is_numeric($courseID))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Course ID must be a number!
                      </div>';
            } else {

                $query = "INSERT INTO course (courseID, courseName, courseLevel, courseLeader, dateCreated, lastUpdated)
                VALUES ('$courseID', '$courseName', '$courseLevel', '$courseLeader', now(), now())";

                if ($connection->query($query) === TRUE) {
                    header("Refresh:0.01; url=courselist.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not insert course!
                          </div>'; 
                }
            }
        }


        $connection->close();

    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Add Course</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="courselist.php">Course List</a>
            </li>
            <li class="breadcrumb-item active">Add Course</li>
        </ol>

        <!-- Add Course Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="addCourseForm" action="addcourse.php" method="POST" enctype="multipart/form-data">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course ID</label>
                            <input type="text" class="form-control" name="courseID" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Name</label>
                            <input type="text" class="form-control" name="courseName" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Level</label>
                            <input type="text" class="form-control" name="courseLevel" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Leader</label>
                            <input type="text" class="form-control" name="courseLeader" required>
                        </div>
                    </div>
                  
                    <button type="submit" class="btn btn-primary" name="submit" id="addButton">Add</button>
              
                </form>

            </div>

        </div>

    </div>

    <?php include "../../includes/footer.php" ?>

    <?php
        
            } else if ($userType == "student" or $userType == "supervisor") {
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