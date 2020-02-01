<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Course List - SPAS</title>

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
    <h1 class="mt-4 mb-3">Course List</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Course List</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">

        <form action="addcourse.php" method="post" role="form">
          <button class="btn btn-success" type="submit">Add New Course</button>
        </form>

        <br>

        <table class="table table-striped">
          <thread>
            <tr>
              <th scope="col">Course ID</th>
              <th scope="col">Course Name</th>
              <th scope="col">Course Level</th>
              <th scope="col">Course Leader</th>
              <th scope="col">Edit</th>
              <th scope="col">Remove</th>
            </tr>
          </thread>

          <tbody>

            <?php

                    $query = "SELECT * FROM course";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $courseID = $row['courseID'];
                                $courseName = $row['courseName'];
                                $courseLevel = $row['courseLevel'];
                                $courseLeader = $row['courseLeader'];

                                echo '<tr>';
                                echo '<th scope="row">' . $courseID . '</th>';
                                echo '<td>' . $courseName . '</td>';
                                echo '<td>' . $courseLevel . '</td>';
                                echo '<td>' . $courseLeader . '</td>';
                                echo '<td>
                                        <form action="editingcourse.php" method="post" role="form">
                                        <input type="hidden" name="courseID" value="'. $courseID .'">
                                        <button class="btn btn-primary" type="submit">Edit</button></form>
                                      </td>';
                                echo '<td>
                                        <form action="../../php/removeCourse.php" method="post" role="form">
                                        <input type="hidden" name="courseID" value="'. $courseID .'">
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