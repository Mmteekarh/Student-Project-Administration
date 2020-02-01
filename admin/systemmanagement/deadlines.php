<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Deadlines - SPAS</title>

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
    <h1 class="mt-4 mb-3">Deadline Management</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Deadline Management</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">

        <form action="adddeadline.php" method="post" role="form">
          <button class="btn btn-success" type="submit">Add New Deadline</button>
        </form>

        <br>

        <table class="table table-striped">
          <thread>
            <tr>
              <th scope="col">Deadline ID</th>
              <th scope="col">Name</th>
              <th scope="col">Weighting</th>
              <th scope="col">Deadline Date</th>
              <th scope="col">Edit</th>
              <th scope="col">Remove</th>
            </tr>
          </thread>

          <tbody>

            <?php

                    $query = "SELECT * FROM deadlines";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $deadlineID = $row['deadlineID'];
                                $deadlineName = $row['deadlineName'];
                                $deadlineWeighting = $row['deadlineWeighting'];
                                $deadlineDate = $row['deadlineDate'];

                                echo '<tr>';
                                echo '<th scope="row">' . $deadlineID . '</th>';
                                echo '<td>' . $deadlineName . '</td>';
                                echo '<td>' . $deadlineWeighting . '</td>';
                                echo '<td>' . $deadlineDate . '</td>';
                                echo '<td>
                                        <form action="editingdeadline.php" method="post" role="form">
                                        <input type="hidden" name="deadlineID" value="'. $deadlineID .'">
                                        <button class="btn btn-primary" type="submit">Edit</button></form>
                                      </td>';
                                echo '<td>
                                        <form action="../../php/removeDeadline.php" method="post" role="form">
                                        <input type="hidden" name="deadlineID" value="'. $deadlineID .'">
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