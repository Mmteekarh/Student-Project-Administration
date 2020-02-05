<!-- Page is the landing page of the admin panel, include links to other pages and general statistics. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../includes/header.php" ?>
    <?php include "../includes/connect.php" ?>
    <?php include "../includes/userscript.php" ?>
    
    <title>Admin Home - SPAS</title>

    <?php

        // Queries used to get number of students, supervisors and projects.
        $studentQuery = "SELECT COUNT(*) AS studentCount FROM student";
        $studentResult = $connection->query($studentQuery);
        $supervisorQuery = "SELECT COUNT(*) AS supervisorCount FROM supervisor";
        $supervisorResult = $connection->query($supervisorQuery);
        $projectQuery = "SELECT COUNT(*) AS projectCount FROM project";
        $projectResult = $connection->query($projectQuery);

        // Gets number of students and stores in a variable.
        if ($studentResult->num_rows > 0) {
            while($studentRow = $studentResult->fetch_assoc()) {
                $totalStudents = $studentRow["studentCount"];
            }
        }

        // Gets number of supervisors and stores in a variable.
        if ($supervisorResult->num_rows > 0) {
            while($supervisorRow = $supervisorResult->fetch_assoc()) {
                $totalSupervisors = $supervisorRow["supervisorCount"];
            }
        }

        // Gets number of projects and stores in a variable.
        if ($projectResult->num_rows > 0) {
            while($projectRow = $projectResult->fetch_assoc()) {
                $totalProjects = $projectRow["projectCount"];
            }
        }

        // Close connection
        $connection->close();

    ?>

</head>

<body>

    <!-- Check if the user is logged in and are a supervisor or admin -->
  	<?php
      	if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

    <!-- Includes admin navigation bar -->
    <?php include "../includes/adminnav.php" ?>

    <!-- Main page content - shows general statistics -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">Admin - Home</h1>
        </center>

        <br>
        <br>

        <!-- Row includes statistics - separated using cards which give the statistics a cleaner look -->
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

        <br>
        <br>

    </div>

    <!-- Includes footer -->
    <?php include "../includes/footer.php" ?>

    <?php
              // If user is a student, redirect to no permissions error page.
            	} else if ($userType == "student") {
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