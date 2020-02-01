<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Supervisor List - SPAS</title>

</head>

<body>

    <?php
      if ($loggedIn == true) {
            if ($userType == "admin") {
  ?>

  <!-- Includes navigation bar -->
  <?php include "../../includes/systemnav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Supervisor List</h1>

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

        <form action="addsupervisor.php" method="post" role="form">
          <button class="btn btn-success" type="submit">Add New Supervisor</button>
        </form>

        <h3>Supervisor List</h3>

        <table class="table table-striped">
          <thread>
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
          </thread>

          <tbody>

            <?php

                    $query = "SELECT * FROM supervisor";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $superID = $row['supervisorID'];
                                $firstName = $row['firstName'];
                                $title = $row['supervisorTitle'];
                                $lastName = $row['lastName'];
                                $activeSupervisor = $row['activeSupervisor'];
                                $officeNumber = $row['officeNumber'];
                                $emailAddress = $row['emailAddress'];
                                $loggedIn = $row['loggedIn'];
                                $admin = $row['admin'];
                                $lastIP = $row['lastIP'];

                                echo '<tr>';
                                echo '<th scope="row">' . $superID . '</th>';
                                echo '<td>' . $title . '</td>';
                                echo '<td>' . $firstName . '</td>';
                                echo '<td>' . $lastName . '</td>';
                                echo '<td>' . $activeSupervisor . '</td>';
                                echo '<td>' . $officeNumber . '</td>';
                                echo '<td>' . $emailAddress . '</td>';
                                echo '<td>' . $loggedIn . '</td>';
                                echo '<td>' . $admin . '</td>';
                                echo '<td>' . $lastIP . '</td>';
                                echo '<td>
                                        <form action="editingsupervisor.php" method="post" role="form">
                                        <input type="hidden" name="superID" value="'. $superID .'">
                                        <button class="btn btn-primary" type="submit">Edit</button></form>
                                      </td>';
                                echo '<td>
                                        <form action="../../php/removeSupervisor.php" method="post" role="form">
                                        <input type="hidden" name="superID" value="'. $superID .'">
                                        <button class="btn btn-danger" type="submit">Remove</button></form>
                                      </td>';
                                echo '</tr>';
                            }
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $connection->error;
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