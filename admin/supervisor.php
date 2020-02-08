<!-- Page for supervisor tools in the admin panel -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../includes/header.php" ?>
    <?php include "../includes/connect.php" ?>
    <?php include "../includes/userscript.php" ?>

    <title>Supervisor Tools - SPAS</title>

    <?php

        // Queries to get statistics from the database. Includes student count, project count and gets if the projects have been allocated
        $studentQuery = "SELECT COUNT(*) AS studentCount FROM student INNER JOIN project ON student.projectID = project.projectID WHERE supervisorID='$loggedInSupervisorID'";
        $studentResult = $connection->query($studentQuery);
        $projectQuery = "SELECT COUNT(*) AS projectCount FROM project WHERE supervisorID='$loggedInSupervisorID'";
        $projectResult = $connection->query($projectQuery);
        $allocationQuery = "SELECT * FROM management";
        $allocationResult = $connection->query($allocationQuery);
        $projectsAllocated = 0;

        // Gets number of students related to the supervisor and stores in a variable.
        if ($studentResult->num_rows > 0) {
            while($studentRow = $studentResult->fetch_assoc()) {
                $totalStudents = $studentRow["studentCount"];
            }
        } else {
             echo '<div class="alert alert-danger" role="alert">
                        Error: We could not load the student data! Please contact an administrator. 
                   </div>';
        }

        // Gets number of projects related to the supervisor and stores in a variable.
        if ($projectResult->num_rows > 0) {
            while($projectRow = $projectResult->fetch_assoc()) {
                $totalProjects = $projectRow["projectCount"];
            }
        } else {
             echo '<div class="alert alert-danger" role="alert">
                        Error: We could not load the project data! Please contact an administrator. 
                   </div>';
        }
    
        // Gets if the projects have been allocated and stores in a variable.
        if ($allocationResult->num_rows > 0) {
            while($allocationRow = $allocationResult->fetch_assoc()) {
                $projectsAllocated = $allocationRow["projectsAllocated"];
            }
        } else {
             echo '<div class="alert alert-danger" role="alert">
                        Error: We could not load the allocation data! Please contact an administrator. 
                   </div>';
        }

    ?>

</head>

<body>

    <!-- Check if the user is logged in and are a supervisor or admin -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
    ?>

    <!-- Includes admin navigation bar -->
    <?php include "../includes/supervisornav.php" ?>

    <!-- Main page content - shows supervisor specific statistics -->
    <div class="container">

        <center>
            <h1 class="mt-4 mb-3">Supervisor Tools</h1>
        </center>

        <!-- Breadcrumb shows links to previous pages -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item active">Supervisor Tools</li>
        </ol>

        <!-- First row shows general supervisor statistics -->
        <div class="row">

            <!-- Checks if projects have been allocated. If they have not, let the supervisor know -->
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

            <!-- If the projects have been allocated, show the number of students related to the supervisor -->
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

            <!-- Show the number of projects the supervisor has active. -->
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

        <br>
        <br>

        <!-- Second row shows a list of the supervisors projects in a table with options to edit and remove. -->
        <div class="row">
            
            <div class="col-lg-12">

                <!-- Button to add new projects -->
                <form action="supervisor/addproject.php" method="POST" role="form">
                    <button class="btn btn-success" type="submit">Add New Project</button>
                </form>

                <br>

                <h3>Your Projects:</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Project ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Maximum Students</th>
                            <th scope="col">Project Code</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                            // Query to select all projects related to the supervisor.
                            $selectProjectQuery = "SELECT * FROM project WHERE supervisorID = '$loggedInSupervisorID'";
                            $selectProjectResult = $connection->query($selectProjectQuery);

                            if ($selectProjectResult->num_rows > 0) {
                                while($selectProjectRow = $selectProjectResult->fetch_assoc()) {

                                    // Get all project details and add to table.
                                    $projectID = $selectProjectRow['projectID'];
                                    $projectTitle = $selectProjectRow['projectTitle'];
                                    $maxStudents = $selectProjectRow['maximumStudents'];
                                    $projectCode = $selectProjectRow['projectCode'];

                                    echo '<tr>';
                                    echo '<th scope="row">' . $projectID . '</th>';
                                    echo '<td>' . $projectTitle . '</td>';
                                    echo '<td>' . $maxStudents . '</td>';
                                    echo '<td>' . $projectCode . '</td>';
                                    echo '<td>
                                              <form action="supervisor/editingproject.php" method="POST" role="form">
                                                  <input type="hidden" name="projectID" value="'. $projectID .'">
                                                  <button class="btn btn-primary" type="submit">Edit</button>
                                              </form>
                                          </td>';
                                    echo '<td>
                                              <form action="../php/removeProject.php" method="POST" role="form">
                                                  <input type="hidden" name="projectID" value="'. $projectID .'">
                                                  <button class="btn btn-danger" type="submit">Remove</button>
                                              </form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo "<tr><td>You do not have any active projects.</td></tr>";
                            }

                        ?>

                    </tbody>

                </table>
            </div>
        </div>

        <br>
        <br>

        <!-- Second row displays a table of students related to the supervisor -->
        <div class="row">

            <h3>Your Students:</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Initial</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Year of Study</th>
                        <th scope="col">PLP?</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                        // If projects have not been allocated - display an empty table.
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

                            // If projects are allocated, display a list of students related to the supervisor.

                            $showStudentsQuery = "SELECT * FROM student INNER JOIN project ON student.projectID = project.projectID WHERE supervisorID = '$loggedInSupervisorID'";
                            $showStudentsResult = $connection->query($showStudentsQuery);

                            if ($showStudentsResult->num_rows > 0) {
                                while($showStudentsRow = $showStudentsResult->fetch_assoc()) {
                                    $studentID = $showStudentsRow['studentID'];
                                    $firstName = $showStudentsRow['firstName'];
                                    $middleInitial = $showStudentsRow['middleInitial'];
                                    $lastName = $showStudentsRow['lastName'];
                                    $yearOfStudy = $showStudentsRow['yearOfStudy'];
                                    $plp = $showStudentsRow['plp'];

                                    if ($plp == 0) {
                                      $plpText = "No";
                                    } else {
                                      $plpText = "Yes";
                                    }

                                    echo '<tr>';
                                    echo '<th scope="row">' . $studentID . '</th>';
                                    echo '<td>' . $firstName . '</td>';
                                    echo '<td>' . $middleInitial . '</td>';
                                    echo '<td>' . $lastName . '</td>';
                                    echo '<td>' . $yearOfStudy . '</td>';
                                    echo '<td>' . $plpText . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo "<tr><td>You do not have any students.</td></tr>";
                            }
                        }

                        // Closes connection
                        $connection->close();

                      ?>

                </tbody>

            </table>

        </div>

    </div>

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