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

        $mainMark = "";

        if (isset($_POST['submit'])) {
            $mainMark = $_POST['mainmark'];

            if (!(is_numeric($mainMark))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Mark must be numeric!
                      </div>'; 
            } else {
                $query = "UPDATE student SET mainMark = ? WHERE studentID = ?";

                if($statement = mysqli_prepare($connection, $query)) {
                    mysqli_stmt_bind_param($statement, "ii", $mainMark, $studentID);
                    mysqli_stmt_execute($statement);
                    header("Refresh:0.01; url=../supervisor.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not update student! Please contact an administrator.
                          </div>'; 
                }

                mysqli_stmt_close($statement);
            }

        }

    ?>

    <!-- Page content includes an add main mark form. -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">Set Main Mark</h1>
            <p><?php echo $studentName; ?></p>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../supervisor.php">Supervisor Tools</a>
            </li>
            <li class="breadcrumb-item active">Set Main Mark</li>
        </ol>

        <!-- Add main mark Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="setMainMark" action="setmainmark.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="studentID" value="<?php echo $studentID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Enter Main Mark</label>
                            <input type="text" class="form-control" name="mainmark" required>
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
