<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Admin - SPAS</title>

  <?php
    $studentQuery = "SELECT COUNT(*) AS studentCount FROM student";
    $supervisorQuery = "SELECT COUNT(*) AS supervisorCount FROM supervisor";
    $projectQuery = "SELECT COUNT(*) AS projectCount FROM project";

    if ($result = mysqli_query($connection, $studentQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $totalStudents = $row["studentCount"];
            }
        }
    }

    if ($result = mysqli_query($connection, $supervisorQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $totalSupervisors = $row["supervisorCount"];
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

    $connection->close();

  ?>

</head>

<body>

	<?php
    	if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

  <!-- Includes navigation bar -->
  <?php include "../includes/adminnav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <center><h1 class="mt-4 mb-3">Admin - Home</h1></center>

    <br><br>

    <div class="row">

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h1><?php echo $totalStudents; ?></h1>
              <h2>Students</h2>
            </center>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h1><?php echo $totalProjects; ?></h1>
              <h2>Projects</h2>
            </center>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h1><?php echo $totalSupervisors; ?></h1>
              <h2>Supervisors</h2>
            </center>
          </div>
        </div>
      </div>

    </div>

    <br><br>

  </div>

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