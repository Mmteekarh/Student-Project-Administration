<!-- Page includes the ability for an admin to add a supervisor -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>

    <title>Add Supervisor - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script for adding a supervisor to the database -->
	<?php

	    $supervisorID = $supervisorTitle = $firstName = $lastName = $officeNumber = $emailAddress = $password = $active = $admin = "";

		if (isset($_POST['submit'])) {
		    $supervisorID = $_POST['supervisorID'];
			$supervisorTitle = $_POST['supervisorTitle'];
		    $firstName = $_POST['firstName'];
		    $lastName = $_POST['lastName'];
		    $officeNumber = $_POST['officeNumber'];
		    $emailAddress = $_POST['emailAddress'];
		    $password = $_POST['password'];
		    $active = $_POST['activeSupervisor'];
		    $admin = $_POST['admin'];

            // Used built-in php function to hash the password.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		    // Converting active and admin variables to enter to the database.
		    if($active == "Yes") {
		        $activeSupervisor = 1;
		    } else if ($active == "No") {
		        $activeSupervisor = 0;
		    } else {
		        $activeSupervisor = 0;
		    }

		    if($admin == "Yes") {
		        $adminRow = 1;
		    } else if ($admin == "No") {
		        $adminRow = 0;
		    } else {
		        $adminRow = 0;
		    }

		    // Form validation
            if (strlen($firstName) > 250) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: First name is too long!
                      </div>';

            } else if (strlen($lastName) > 50) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Last name is too long!
                      </div>';

            } else if (!(is_numeric($supervisorID))) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Supervisor ID must be a number!
                      </div>';

            } else {

				$query = "INSERT INTO supervisor (supervisorID, supervisorTitle, firstName, lastName, activeSupervisor, officeNumber, emailAddress, password, loggedIn, admin, dateCreated, lastUpdated)
				VALUES ('$supervisorID', '$supervisorTitle', '$firstName', '$lastName', $activeSupervisor, '$officeNumber', '$emailAddress', '$hashedPassword', 0, $adminRow, now(), now())";

				if ($connection->query($query) === TRUE) {
					header("Refresh:0.01; url=supervisorlist.php");
				} else {
				    echo '<div class="alert alert-danger" role="alert">
                                Error: Could not insert supervisor! Please contact an administrator.
                          </div>'; 
				}

			}

		}

		$connection->close();

	?>

    <!-- Page content includes add supervisor form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Add Supervisor</h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../supervisorlist.php">Supervisor List</a>
            </li>
            <li class="breadcrumb-item active">Add Supervisor</li>
        </ol>

        <!-- Add Supervisor Form -->
        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="addSupervisorForm" action="addsupervisor.php" method="POST" enctype="multipart/form-data">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Supervisor ID</label>
                            <input type="text" class="form-control" name="supervisorID" required>
                        </div>
                    </div>

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
                            <input type="text" class="form-control" name="firstName" required data-validation-required-message="First Name">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastName" required data-validation-required-message="Last Name">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Office Number</label>
                            <input type="text" class="form-control" name="officeNumber" required data-validation-required-message="Office Number">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address</label>
                            <input type="text" class="form-control" name="emailAddress" required data-validation-required-message="Email Address">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required data-validation-required-message="Password">
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

                    <button name="submit" type="submit" class="btn btn-primary" id="addButton">Add</button>
          
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