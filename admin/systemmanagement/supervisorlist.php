<!-- Page displays list of supervisors -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Supervisor List - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script that removes supervisor from the database -->
    <?php

        if (isset($_POST['updateInactive'])) {

            $supervisorID = $_POST['supervisorID'];

            $query = "UPDATE supervisor SET activeSupervisor = 0 WHERE supervisorID = '$supervisorID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully made supervisor inactive!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not update supervisor!
                       </div>';
            }

        }

        if (isset($_POST['updateActive'])) {

            $supervisorID = $_POST['supervisorID'];

            $query = "UPDATE supervisor SET activeSupervisor = 1 WHERE supervisorID = '$supervisorID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully made supervisor active!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not update supervisor!
                       </div>';
            }

        }

        if (isset($_POST['remove'])) {

            $supervisorID = $_POST['supervisorID'];

            $query = "DELETE FROM supervisor WHERE supervisorID = '$supervisorID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully removed supervisor!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove supervisor!
                       </div>';
            }

        }

    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Supervisor List</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item active">Supervisor List</li>
        </ol>

        <div class="row">

            <div class="col-md-12">

                <form action="addsupervisor.php" method="POST" role="form">
                    <button class="btn btn-success" type="submit">Add New Supervisor</button>
                </form>

                <br>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Supervisor ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Active?</th>
                            <th scope="col">Office Number</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Logged In?</th>
                            <th scope="col">System Admin?</th>
                            <th scope="col">Last IP</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                            $query = "SELECT * FROM supervisor";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $supervisorID = $row['supervisorID'];
                                    $firstName = $row['firstName'];
                                    $title = $row['supervisorTitle'];
                                    $lastName = $row['lastName'];
                                    $activeSupervisor = $row['activeSupervisor'];
                                    $officeNumber = $row['officeNumber'];
                                    $emailAddress = $row['emailAddress'];
                                    $loggedIn = $row['loggedIn'];
                                    $admin = $row['admin'];
                                    $lastIP = $row['lastIP'];

                                    if ($activeSupervisor == 1) {
                                        $activeSupervisorText = "Yes";
                                    } else {
                                        $activeSupervisorText = "No";
                                    }

                                    if ($loggedIn == 1) {
                                        $loggedInText = "Yes";
                                    } else {
                                        $loggedInText = "No";
                                    }

                                    if ($admin == 1) {
                                        $adminText = "Yes";
                                    } else {
                                        $adminText = "No";
                                    }

                                    echo '<tr>';
                                    echo '<th scope="row">' . $supervisorID . '</th>';
                                    echo '<td>' . $title . '</td>';
                                    echo '<td>' . $firstName . '</td>';
                                    echo '<td>' . $lastName . '</td>';
                                    echo '<td>' . $activeSupervisorText . '</td>';
                                    echo '<td>' . $officeNumber . '</td>';
                                    echo '<td>' . $emailAddress . '</td>';
                                    echo '<td>' . $loggedInText . '</td>';
                                    echo '<td>' . $adminText . '</td>';
                                    echo '<td>' . $lastIP . '</td>';
                                    echo '<td>
                                              <form action="editingsupervisor.php" method="post" role="form">
                                                  <input type="hidden" name="supervisorID" value="'. $supervisorID .'">
                                                  <button class="btn btn-primary" type="submit">Edit</button>
                                              </form>
                                          </td>';
                                    if ($activeSupervisor == 1) {
                                        echo '<td>
                                                  <form action="supervisorlist.php" method="post" role="form">
                                                      <input type="hidden" name="supervisorID" value="'. $supervisorID .'">
                                                      <button class="btn btn-warning" name="updateInactive" type="submit">Set Inactive</button>
                                                  </form>
                                              </td>';
                                    } else {
                                        echo '<td>
                                                  <form action="supervisorlist.php" method="post" role="form">
                                                      <input type="hidden" name="supervisorID" value="'. $supervisorID .'">
                                                      <button class="btn btn-success" name="updateActive" type="submit">Set Active</button>
                                                  </form>
                                              </td>';
                                    }
                                    echo '<td>
                                              <form action="supervisorlist.php" method="post" role="form">
                                                  <input type="hidden" name="supervisorID" value="'. $supervisorID .'">
                                                  <button class="btn btn-danger" name="remove" type="submit">Remove</button>
                                              </form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td>No supervisors! Add some using the buttons above.</td></tr>';
                            }

                            // Closes connection
                            $connection->close();

                        ?>

                    </tbody>

                </table>

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