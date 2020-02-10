<!-- Page includes add student form -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/connect.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Add Student - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script for adding a student to the database -->
    <?php

        $studentID = $firstName = $lastName = $middleInitial = $yearOfStudy = $plp = $password = $courseID = "";

        if (isset($_POST['submit'])) {
            $studentID = $_POST['studentID'];
            $firstName = $_POST['firstName'];
            $middleInitial = $_POST['middleInitial'];
            $lastName = $_POST['lastName'];
            $yearOfStudy = $_POST['yearOfStudy'];
            $plp = $_POST['plp'];
            $password = $_POST['password'];
            $courseID = $_POST['courseID'];

            // Used built-in php function to hash the password.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            echo $hashedPassword;

            // Form validation
            if (strlen($firstName) > 250) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: First name is too long!
                      </div>';

            } else if (strlen($lastName) > 50) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Last name is too long!
                      </div>';

            } else if (!(is_numeric($studentID))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Student ID must be a number!
                      </div>';

            } else {

                $query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password, courseID, dateCreated, lastUpdated)
                VALUES ('$studentID', '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', '$plp', '$hashedPassword', '$courseID', now(), now())";

                if ($connection->query($query) === TRUE) {
                    header("Refresh:0.01; url=studentlist.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not add student! Please contact an administrator.
                          </div>'; 
                }
            }

        }

    ?>

    <!-- Page content includes add student form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Add Student</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../studentlist.php">Student List</a>
            </li>
            <li class="breadcrumb-item active">Add Student</li>
        </ol>

        <!-- Add Student Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="addStudentForm" action="addstudent.php" method="POST" enctype="multipart/form-data">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Student ID</label>
                            <input type="text" class="form-control" name="studentID" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstName" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Middle Initial</label>
                            <input type="text" class="form-control" name="middleInitial">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastName" required>
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
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Course</label>
                            <select name="courseID">

                                <?php

                                    // Query to get the list of courses, used in a checkbox style.
                                    $query = "SELECT * FROM course";
                                    $result = $connection->query($query);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $courseName = $row['courseName'];
                                            $courseID = $row['courseID'];

                                            echo '<option value="' . $courseID . '">' . $courseName . '</option>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">
                                                    Error: Could not retrieve courses - no records found.
                                              </div>'; 
                                    }

                                    $connection->close();

                                ?>
                                
                            </select>
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