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

            <div class="col-lg-8 mb-4">

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
                                    echo '<td>
                                              <form action="../../php/removeSupervisor.php" method="post" role="form">
                                                  <input type="hidden" name="supervisorID" value="'. $supervisorID .'">
                                                  <button class="btn btn-danger" type="submit">Remove</button>
                                              </form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                            Error: Could not retrieve supervisor data - No records found. 
                                      </div>';
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