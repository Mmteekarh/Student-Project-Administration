<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Supervisor Tools - SPAS</title>

  <?php
    $studentQuery = "SELECT COUNT(*) AS studentCount FROM student INNER JOIN project ON student.projectID = project.projectID WHERE supervisorID='$supervisorID'";
    $projectQuery = "SELECT COUNT(*) AS projectCount FROM project WHERE supervisorID='$supervisorID'";
    $allocationQuery = "SELECT * FROM management";

    if ($result = mysqli_query($connection, $studentQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $totalStudents = $row["studentCount"];
            }
        }
    }

    if ($result = mysqli_query($connection, $projectQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $totalProjects = $row["projectCount"];
            }
        }
    }

    if ($result = mysqli_query($connection, $allocationQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $projectsAllocated = $row["projectsAllocated"];
            }
        }
    }

    $connection->close();

  ?>

</head>

<body>

  <?php
    if ($loggedIn == true) {
      if ($userType == "supervisor" or $userType == "admin") {
  ?>

  <!-- Includes navigation bar -->
  <?php include "../includes/supervisornav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <h1 class="mt-4 mb-3">Admin - Supervisor Tools</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">Supervisor Tools</li>
    </ol>

    <div class="row">

      <?php
        if ($projectsAllocated == 0) {
      ?>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <center>
              <h4>Projects have not<br> been allocated yet</h4>
              <br>
            </center>
          </div>
        </div>
      </div>

      <?php
        } else {
      ?>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <center>
                <h1><?php echo $totalStudents; ?></h1>
                <h2>Your Students</h2>
              </center>
            </div>
          </div>
        </div>
      <?php
        }
      ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <center>
              <h1><?php echo $totalProjects; ?></h1>
              <h2>Your Projects</h2>
            </center>
          </div>
        </div>
      </div>

    </div>

    <br><br>

    <div class="row">

      <h3>Your Projects:</h3>
      <table class="table table-striped">
          <thread>
            <tr>
              <th scope="col">Project ID</th>
              <th scope="col">Title</th>
              <th scope="col">Maximum Students</th>
              <th scope="col">Project Code</th>

            </tr>
          </thread>

          <tbody>

            <?php

                    $query = "SELECT * FROM project WHERE supervisorID='$supervisorID'";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $projectID = $row['projectID'];
                                $projectTitle = $row['projectTitle'];
                                $maxStudents = $row['maximumStudents'];
                                $projectCode = $row['projectCode'];

                                echo '<tr>';
                                echo '<th scope="row">' . $projectID . '</th>';
                                echo '<td>' . $projectTitle . '</td>';
                                echo '<td>' . $maxStudents . '</td>';
                                echo '<td>' . $projectCode . '</td>';
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

    <br><br>

    <div class="row">

      <h3>Your Students:</h3>
      <table class="table table-striped">
          <thread>
            <tr>
              <th scope="col">Student ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Middle Initial</th>
              <th scope="col">Last Name</th>
              <th scope="col">Year of Study</th>
              <th scope="col">PLP?</th>

            </tr>
          </thread>

          <tbody>

            <?php
              if ($projectsAllocated == 0) {
                echo '<tr>';
                echo '<th scope="row">Not yet allocated</th>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
              } else {
                    $query = "SELECT * FROM student INNER JOIN project ON student.projectID=project.projectID WHERE supervisorID='$supervisorID'";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $stuID = $row['studentID'];
                                $firstName = $row['firstName'];
                                $middleInitial = $row['middleInitial'];
                                $lastName = $row['lastName'];
                                $yearOfStudy = $row['yearOfStudy'];
                                $plp = $row['plp'];

                                echo '<tr>';
                                echo '<th scope="row">' . $stuID . '</th>';
                                echo '<td>' . $firstName . '</td>';
                                echo '<td>' . $middleInitial . '</td>';
                                echo '<td>' . $lastName . '</td>';
                                echo '<td>' . $yearOfStudy . '</td>';
                                echo '<td>' . $plp . '</td>';
                                echo '</tr>';
                            }
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $connection->error;
                    }
                  }

                    // Closes connection
                    $connection->close();

                ?>

          </tbody>
        </table>

    </div>

  </div>
  <!-- /.container -->

  <?php include "../includes/footer.php" ?>

  <?php
        
          } else if ($userType == "student") {
            // Invalid Permissions
            header("Refresh:0.01; url=../error/permissionerror.php");

          } else {
              // Invalid user type
              header("Refresh:0.01; url=../error/usertypeerror.php");
          }
        } else {
            header("Refresh:0.01; url=../login.php");
        }
    ?>

</body>

</html>