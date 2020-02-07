<!-- Landing page for system administrators, contains statistics and links to other pages -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../includes/header.php" ?>
    <?php include "../includes/connect.php" ?>
    <?php include "../includes/userscript.php" ?>

    <title>Admin - SPAS</title>

    <?php

        // Query to get the number of deadlines.
        $deadlineQuery = "SELECT COUNT(*) AS deadlines FROM deadlines";
        $deadlineResult = $connection->query($deadlineQuery);

        if ($deadlineResult->num_rows > 0) {
            while($deadlineRow = $deadlineResult->fetch_assoc()) {
                $deadlineNumber = $deadlineRow["deadlines"];
            }
        }

        // Query to get whether projects have been allocated or not.
        $managementQuery = "SELECT * FROM management";
        $managementResult = $connection->query($managementQuery);

        if ($managementResult->num_rows > 0) {
            while($managementRow = $managementResult->fetch_assoc()) {
                $projectsAllocated = $managementRow["projectsAllocated"];
            }
        }

        // Query to get the number of students chosen projects.
        $studentChoiceQuery = "SELECT COUNT(*) AS studentsChosenProjects FROM student WHERE coalesce(projectFirstChoice, projectSecondChoice, projectThirdChoice) is not null";
        $studentChoiceResult = $connection->query($studentChoiceQuery);

        if ($studentChoiceResult->num_rows > 0) {
            while($studentChoiceRow = $studentChoiceResult->fetch_assoc()) {
                $studentsChosenProjects = $studentChoiceRow["studentsChosenProjects"];
            }
        }

        // Query to get the number of students.
        $studentQuery = "SELECT COUNT(*) AS studentCount FROM student";
        $studentResult = $connection->query($studentQuery);

        if ($studentResult->num_rows > 0) {
            while($studentRow = $studentResult->fetch_assoc()) {
                $studentCount = $studentRow["studentCount"];
            }
        }

        // Closes connection
        $connection->close();

  ?>

</head>

<body>

    <!-- Ensures user is logged in and is an admin before loading the page -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../includes/systemnav.php" ?>

    <!-- Page content includes administrator statistics and ability to allocate projects. -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">System Management</h1>
        </center>

        <!-- Breadcrumb to previous pages -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item active">System Management</li>
        </ol>

        <!-- Row includes cards with allocation and deadline statistics. -->
        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <center>

                            <!-- Form posts to php scripts which allocates student projects -->
                            <?php 

                                if ($projectsAllocated == 0) { 
                                    echo "<h4>Allocate Projects</h4>";
                                    echo "<br>";
                                    echo '<form action="../php/allocateProjects.php" method="POST" role="form">';
                                    echo '<button class="btn btn-danger" type="submit">ALLOCATE</button>';
                                    echo "</form>";
                                    echo "<br>";
                                    echo "<small><p><em>Warning: If any students have not chosen their projects, these will have to be allocated manually.</em></p></small>";
                                } else {
                                    echo "<h4>Allocate Projects</h4>";
                                    echo "<br>";
                                    echo "Projects have been allocated!";
                                    echo "<br>";
                                }

                            ?>

                        </center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <center>

                            <!-- Shows number of deadlines -->
                            <h1><?php echo $deadlineNumber; ?></h1>
                            <h2>Deadlines</h2>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <!-- Shows number of students that have completed their choices -->
                            <h1><?php echo $studentsChosenProjects . "/" . $studentCount; ?></h1>
                            <h4>Students Completed Choices</h4>
                        </center>
                    </div>
                </div>
            </div>

        </div>

        <br>

    </div>

    <?php include "../includes/footer.php" ?>

    <?php
          
            // If user is supervisor or student, display permission error.
            } else if ($userType == "student" or $userType == "supervisor") {
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