<!-- Page includes a form for a supervisor to add a project -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/connect.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Set Mark - SPAS</title>

</head>

<body>

    <!-- Check if the user is logged in and are a supervisor or admin -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/supervisornav.php" ?>


    <!-- Script for adding a mark to the database -->
    <?php

        $studentID = $_POST['studentID'];
        $studentName = $_POST['studentName'];

        $secondMark = "";

        if (isset($_POST['submit'])) {
            $secondMark = $_POST['secondmark'];

            if (!(is_numeric($secondMark))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Mark must be numeric!
                      </div>'; 
            } else {
                $markQuery = "UPDATE student SET secondaryMark = $secondMark WHERE studentID = $studentID";

                if ($connection->query($markQuery) === TRUE) {
                    header("Refresh:0.01; url=../supervisor.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not update student! Please contact an administrator.
                          </div>'; 
                }
            }

        }

    ?>

    <!-- Page content includes an add secondary mark form. -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">Set Secondary Mark</h1>
            <p><?php echo $studentName; ?></p>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../supervisor.php">Supervisor Tools</a>
            </li>
            <li class="breadcrumb-item active">Set Secondary Mark</li>
        </ol>

        <!-- Add main mark Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="setSecondMark" action="setsecondmark.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="studentID" value="<?php echo $studentID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Enter Secondary Mark</label>
                            <input type="text" class="form-control" name="secondmark" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit" id="addButton">Set</button>

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
