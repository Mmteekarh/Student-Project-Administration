<!-- Page shows account details and allows user to change password and view information. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/connect.php" ?>
    <?php include "includes/header.php" ?>
    <?php include "includes/userscript.php" ?>

    <title>Account - SPAS</title>

    <?php

        // Check if user is a student and if so, get student information.
        if ($userType == "student") {
        
            $query = "SELECT * FROM student WHERE studentID='$loggedInStudentID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $studentFirstName = $row["firstName"];
                  $studentMiddleInitial = $row["middleInitial"];
                  $studentLastName = $row["lastName"];
                  $studentYearOfStudy = $row["yearOfStudy"];
                  $user = "Student";
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                          Error: We could not retrieve your data! Please contact an administrator. 
                      </div>';
            }

        // Checks if user is a supervisor or admin and gets their details.
        } else if ($userType == "supervisor" or $userType == "admin") {

            $query = "SELECT * FROM supervisor WHERE supervisorID='$loggedInSupervisorID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $supervisorFirstName = $row["firstName"];
                    $supervisorLastName = $row["lastName"];
                    $supervisorEmailAddress = $row["emailAddress"];
                    $supervisorOfficeNumber = $row["officeNumber"];

                    if ($row["admin"] == 1) {
                      $user = "Administrator";
                    } else {
                      $user = "Supervisor";
                    }
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                          Error: We could not retrieve your data! Please contact an administrator. 
                      </div>';
            }
        } else {
            // User type error
            header("Refresh:0.01; url=error/invalidusererror.php");
        }
    ?>

</head>

<body>

    <!-- Check if user is logged in and a valid user type -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "student" or $userType == "admin" or $userType == "supervisor") {
    ?>

    <!-- Includes main navbar -->
    <?php include "includes/mainnav.php" ?>

    <!-- Script changes a users password -->
    <?php

        if (isset($_POST['submit'])) {

            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];
            $userType = $_POST['userType'];

            if ($userType == "student") {

                $studentQuery = "SELECT * FROM student WHERE lastIP = '$ip' AND loggedIn = 1";
                $studentResult = $connection->query($studentQuery);

                if ($studentResult->num_rows > 0) {
                    while($studentRow = $studentResult->fetch_assoc()) {

                        if ($currentPassword == $studentRow["password"]) {
                            if ($newPassword == $confirmNewPassword) {

                                $studentUpdateQuery = "UPDATE student SET password = '$newPassword' WHERE lastIP = '$ip'";

                                if ($connection->query($studentUpdateQuery) === TRUE) {
                                    echo '<div class="alert alert-success" role="alert">
                                                Successfully changed password!
                                          </div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">
                                                Error: Could not update password! Please contact an administrator.
                                          </div>';
                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                            Error: Passwords do not match!
                                      </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                                        Error: Incorrect password!
                                  </div>';
                        }
                    }
                }

            } else if ($userType == "supervisor" or $userType == "admin") {

                $supervisorQuery = "SELECT * FROM supervisor WHERE lastIP = '$ip' AND loggedIn = 1";
                $supervisorResult = $connection->query($supervisorQuery);

                if ($supervisorResult->num_rows > 0) {
                    while($supervisorRow = $supervisorResult->fetch_assoc()) {

                        if ($currentPassword == $supervisorRow["password"]) {
                            if ($newPassword == $confirmNewPassword) {

                                $supervisorUpdateQuery = "UPDATE supervisor SET password = '$newPassword' WHERE lastIP = '$ip'";

                                if ($connection->query($supervisorUpdateQuery) === TRUE) {
                                    echo '<div class="alert alert-success" role="alert">
                                                Successfully changed password!
                                          </div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">
                                                Error: Could not update password! Please contact an administrator.
                                          </div>';
                                }

                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                            Error: Passwords do not match!
                                      </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                                        Error: Incorrect password!
                                  </div>';
                        }
                    }
                }

            } else {
                // Invalid user type
                header("Refresh:0.01; url=error/usertypeerror.php");
            }
        }

        $connection->close();


    ?>

    <!-- Page content includes change password form and account details. -->
    <div class="container">

        <header>

            <br>
            <center><h2>My Account</h2></center>
            <br>

        </header>

        <!-- Row contains change password and account information -->
        <div class="row">

            <!-- Half of the page dedicated to changing password -->
            <div class="col-md-6 border">

                <br>

                <h4>Change Password</h4>
                
                <br>

                <!-- Form used to change the users password, posts to php script -->
                <form name="changePassword" action="account.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" class="form-control" name="userType" value="<?php echo $userType; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Current Password</label>
                            <input type="password" class="form-control" name="currentPassword" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="newPassword" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" name="confirmNewPassword" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit" id="changePasswordButton">Change Password</button>
                </form>

            <br>

            </div>

            <!-- Second column contains users' account details -->
            <div class="col-md-6 border">

                <br>

                <h4>Account Details</h4>

                <br>

                <?php 
                    // Check if user is a student or supervisor and display their details.
                    if ($userType == "student") {
                        echo "<b>First Name: </b>" . $studentFirstName;
                        echo "<br><b>Middle Initial: </b>" . $studentMiddleInitial;
                        echo "<br><b>Last Name: </b>" . $studentLastName;
                        echo "<br><b>Year of Study: </b>" . $studentYearOfStudy;
                        echo "<br><b>User Type: </b>" . $user;
                    } else if ($userType == "supervisor" or $userType == "admin") {
                        echo "<b>First Name: </b>" . $supervisorFirstName;
                        echo "<br><b>Last Name: </b>" . $supervisorLastName;
                        echo "<br><b>Email Address: </b>" . $supervisorEmailAddress;
                        echo "<br><b>Office Number: </b>" . $supervisorOfficeNumber;
                        echo "<br><b>User Type: </b>" . $user;
                    } else {
                        // Invalid user type, redirects to error page.
                        header("Refresh:0.01; url=error/usertypeerror.php");
                    }
                ?>

              <br>

              <p><em><small>If these details are incorrect, please contact an administrator</small></em></p>

              <br>

            </div>

        </div>

    </div>

    <br>
    <br>
  
  <!-- Includes footer -->
  <?php include "includes/footer.php" ?>

  <?php
        
          } else {
              // Invalid user type, redirects to error page.
              header("Refresh:0.01; url=error/usertypeerror.php");
          }
        } else {
            // If the user is not logged in, redirect to login page.
            header("Refresh:0.01; url=login.php");
        }
    ?>

</body>

</html>