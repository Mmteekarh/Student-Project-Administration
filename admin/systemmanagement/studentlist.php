<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Student List - SPAS</title>

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
    <h1 class="mt-4 mb-3">Student List</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Student List</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">

        <form action="addstudent.php" method="post" role="form">
          <button class="btn btn-success" type="submit">Add New Student</button>
        </form>

        <br>

        <form action="importstudents.php" method="post" role="form">
          <button class="btn btn-success" type="submit">Import Students</button>
        </form>

        <br>

        <table class="table table-striped">
          <thread>
            <tr>
              <th scope="col">Student ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Middle Initial</th>
              <th scope="col">Last Name</th>
              <th scope="col">Year of Study</th>
              <th scope="col">PLP?</th>
              <th scope="col">Course</th>
              <th scope="col">Logged In?</th>
              <th scope="col">Last IP</th>
              <th scope="col">Edit</th>
              <th scope="col">Remove</th>

            </tr>
          </thread>

          <tbody>

            <?php

                    $query = "SELECT * FROM student INNER JOIN course ON student.courseID=course.courseID";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $stuID = $row['studentID'];
                                $firstName = $row['firstName'];
                                $middleInitial = $row['middleInitial'];
                                $lastName = $row['lastName'];
                                $yearOfStudy = $row['yearOfStudy'];
                                $plp = $row['plp'];
                                $loggedIn = $row['loggedIn'];
                                $lastIP = $row['lastIP'];
                                $courseName;

                                if (is_null($row['courseName'])) {
                                  $courseName = "No Course";
                                } else {
                                  $courseName = $row['courseName'];
                                }

                                echo '<tr>';
                                echo '<th scope="row">' . $stuID . '</th>';
                                echo '<td>' . $firstName . '</td>';
                                echo '<td>' . $middleInitial . '</td>';
                                echo '<td>' . $lastName . '</td>';
                                echo '<td>' . $yearOfStudy . '</td>';
                                echo '<td>' . $plp . '</td>';
                                echo '<td>' . $courseName . '</td>';
                                echo '<td>' . $loggedIn . '</td>';
                                echo '<td>' . $lastIP . '</td>';
                                echo '<td>
                                        <form action="editingstudent.php" method="post" role="form">
                                        <input type="hidden" name="stuID" value="'. $stuID .'">
                                        <button class="btn btn-primary" type="submit">Edit</button></form>
                                      </td>';
                                echo '<td>
                                        <form action="../../php/removeStudent.php" method="post" role="form">
                                        <input type="hidden" name="stuID" value="'. $stuID .'">
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