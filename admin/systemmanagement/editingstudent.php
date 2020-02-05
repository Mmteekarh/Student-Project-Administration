<!-- Page used to edit student details -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Editing Student - SPAS</title>

    <?php

        $studentID = $_POST['studentID'];

        $query = "SELECT * FROM student WHERE studentID='$studentID'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $middleInitial = $row["middleInitial"];
                $firstName = $row["firstName"];
                $lastName = $row["lastName"];
                $yearOfStudy = $row["yearOfStudy"];
                $plp = $row["plp"];
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
            <h1 class="mt-4 mb-3">Editing Student</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemnav.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="editstudent.php">Edit Student</a>
            </li>
            <li class="breadcrumb-item active">Editing Student</li>
        </ol>

        <!-- Editing Student Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="editStudentForm" action="../../php/editStudent.php" method="POST" enctype="multipart/form-data">
          
                    <input type="hidden" name="studentID" value="<?php echo $studentID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Middle Initial</label>
                            <input type="text" class="form-control" name="middleInitial" value="<?php echo $middleInitial; ?>">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Year of Study</label>
                            <select name="yearOfStudy">
                                <option value="2019/2020">2019/2020</option>
                                <option value="2020/2021">2020/2021</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>PLP</label>
                            <select name="plp">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course</label>
                            <select name="courseID">

                                <?php

                                    $query = "SELECT * FROM course";
                                    $result = $connection->query($query);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $courseName = $row['courseName'];
                                            $courseID = $row['courseID'];

                                            echo '<option value="' . $courseID . '">' . $courseName . '</option>';
                                        }
                                    } else {
                                        echo "Error: No records found in the table!";
                                    }
                                ?>

                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="editButton">Edit</button>
          
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