<!-- Page for editing supervisor details -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Editing Supervisor - SPAS</title>

    <?php

        $supervisorID = $_POST['supervisorID'];

        $query = "SELECT * FROM supervisor WHERE supervisorID = '$supervisorID'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $supervisorTitle = $row["supervisorTitle"];
                $firstName = $row["firstName"];
                $lastName = $row["lastName"];
                $activeSupervisor = $row["activeSupervisor"];
                $officeNumber = $row["officeNumber"];
                $emailAddress = $row["emailAddress"];
                $admin = $row["admin"];
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
            <h1 class="mt-4 mb-3">Editing Supervisor</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="supervisorlist.php">Supervisor List</a>
            </li>
            <li class="breadcrumb-item active">Editing Supervisor</li>
        </ol>

        <!-- Editing Supervisor Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="supervisorForm" action="../../php/editSupervisor.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="supervisorID" value="<?php echo $supervisorID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Supervisor Title</label>
                            <select name="supervisorTitle">
                                <option>Dr</option>
                                <option>Professor</option>
                                <option>Mr</option>
                                <option>Mrs</option>
                                <option>Miss</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>" required>
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
                            <label>Office Number</label>
                            <input type="text" class="form-control" name="officeNumber" value="<?php echo $officeNumber; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="emailAddress" value="<?php echo $emailAddress; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="form-check">
                            <label>Active Supervisor?</label><br>
                            <label class="radio-inline"><input value="Yes" type="radio" name="activeSupervisor" checked>Yes</label>
                            <label class="radio-inline"><input value="No" type="radio" name="activeSupervisor">No</label>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="form-check">
                            <label>System Administrator?</label><br>
                            <label class="radio-inline"><input value="Yes" type="radio" name="admin">Yes</label>
                            <label class="radio-inline"><input value="No" type="radio" name="admin" checked>No</label>
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