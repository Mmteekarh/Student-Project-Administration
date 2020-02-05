<!-- Page allows the admin to edit course details -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Editing Course - SPAS</title>

    <?php

        $courseID = $_POST['courseID'];
        
        // Query gets information about the course based on the courseID from the post request.
        $query = "SELECT * FROM course WHERE courseID='$courseID'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $courseName = $row["courseName"];
                $courseLevel = $row["courseLevel"];
                $courseLeader = $row["courseLeader"];
            }
        }

    ?>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Editing Course</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemnav.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="courselist.php">Course List</a>
            </li>
            <li class="breadcrumb-item active">Editing Course</li>
        </ol>

        <!-- Editing Course Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="editCourseForm" action="../../php/editCourse.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Name</label>
                            <input type="text" class="form-control" name="courseName" value="<?php echo $courseName; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Level</label>
                            <input type="text" class="form-control" name="courseLevel" value="<?php echo $courseLevel; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course Leader</label>
                            <input type="text" class="form-control" name="courseLeader" value="<?php echo $courseLeader; ?>" required>
                        </div>
                    </div>
          
                    <button type="submit" class="btn btn-primary" id="addButton">Edit</button>
          
                </form>

            </div>

        </div>

    </div>

    <?php include "../../includes/footer.php" ?>

    <?php
        
            } else if ($userType == "supervisor" or $userType == "student") {
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

