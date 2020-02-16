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

    <!-- Script used to remove a project -->
    <?php

        if (isset($_POST['submit'])) {

            $projectID = $_POST['projectID'];

            $projectQuery = "DELETE FROM project WHERE projectID = '$projectID'";

            if ($connection->query($projectQuery) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully removed project!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove project!
                       </div>';
            }

            $projectCourseQuery = "DELETE FROM projectCourse WHERE projectID = '$projectID'";

            if (!($connection->query($projectCourseQuery) === TRUE)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove project-course match!
                      </div>';
            }

            $firstChoiceQuery = "UPDATE student SET projectFirstChoice = NULL WHERE projectFirstChoice = '$projectID'";

            if (!($connection->query($firstChoiceQuery) === TRUE)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove student-first choice match!
                      </div>';
            }

            $secondChoiceQuery = "UPDATE student SET projectSecondChoice = NULL WHERE projectSecondChoice = '$projectID'";

            if (!($connection->query($secondChoiceQuery) === TRUE)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove student-second choice match!
                      </div>';
            }

            $thirdChoiceQuery = "UPDATE student SET projectThirdChoice = NULL WHERE projectThirdChoice = '$projectID'";

            if (!($connection->query($thirdChoiceQuery) === TRUE)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not student-third choice match!
                      </div>';
            }

            $confirmedChoiceQuery = "UPDATE student SET projectID = NULL WHERE projectID = '$projectID'";

            if (!($connection->query($confirmedChoiceQuery) === TRUE)) {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not student-confirmed choice match!
                      </div>';
            }
        }

    ?>

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
            
            <div class="col-md-12">

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
                                    if ($projectsAllocated == 0) {
                                        echo '<td>
                                                  <form action="supervisor/editingproject.php" method="POST" role="form">
                                                      <input type="hidden" name="projectID" value="'. $projectID .'">
                                                      <button class="btn btn-primary" type="submit">Edit</button>
                                                  </form>
                                              </td>';
                                        echo '<td>
                                                  <form action="supervisor.php" method="POST" role="form">
                                                      <input type="hidden" name="projectID" value="'. $projectID .'">
                                                      <button class="btn btn-danger" name="submit" type="submit">Remove</button>
                                                  </form>
                                              </td>';
                                    } else {
                                        echo '<td>Cannot edit or remove once projects have been allocated.</td>';
                                    }
                                    
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

            <div class="col-md-12">

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
                            <th scope="col">EthOS</th>
                            <th scope="col">1st Mark</th>
                            <th scope="col">2nd Mark</th>
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
                                        $ethos = $showStudentsRow['ethosNumber'];
                                        $mainMark = $showStudentsRow['mainMark'];
                                        $secondaryMark = $showStudentsRow['secondaryMark'];

                                        if ($plp == 0) {
                                          $plpText = "No";
                                        } else {
                                          $plpText = "Yes";
                                        }

                                        if (is_null($ethos)) {
                                            $ethos = "Not Set";
                                        }

                                        $studentName = $firstName . " " . $lastName;

                                        echo '<tr>';
                                        echo '<th scope="row">' . $studentID . '</th>';
                                        echo '<td>' . $firstName . '</td>';
                                        echo '<td>' . $middleInitial . '</td>';
                                        echo '<td>' . $lastName . '</td>';
                                        echo '<td>' . $yearOfStudy . '</td>';
                                        echo '<td>' . $plpText . '</td>';
                                        if ($ethos == "Not Set") {
                                            echo '<td>
                                                      <form action="supervisor/addethos.php" method="POST" role="form">
                                                          <input type="hidden" name="studentID" value="'. $studentID .'">
                                                          <input type="hidden" name="studentName" value="'. $studentName .'">
                                                          <button class="btn btn-success" name="ethos" type="submit">Add EthOS</button>
                                                      </form>
                                                  </td>';
                                        } else {
                                            echo '<td>' . $ethos . '</td>';
                                        }
                                        if ($mainMark == 0 or is_null($mainMark)) {
                                            echo '<td>
                                                      <form action="supervisor/setmainmark.php" method="POST" role="form">
                                                          <input type="hidden" name="studentID" value="'. $studentID .'">
                                                          <input type="hidden" name="studentName" value="'. $studentName .'">
                                                          <button class="btn btn-success" name="mainmark" type="submit">Set Mark</button>
                                                      </form>
                                                  </td>';
                                        } else {
                                            echo '<td>' . $mainMark . '</td>';
                                        }
                                        if ($secondaryMark == 0 or is_null($secondaryMark)) {
                                            echo '<td>Not Marked</td>';
                                        } else {
                                            echo '<td>' . $secondaryMark . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "<tr><td>You do not have any students.</td></tr>";
                                }
                            }

                          ?>

                    </tbody>

                </table>

            </div>

        </div>

        <br>

        <?php if ($projectsAllocated == 1) { ?>

        <div class="row">
            <div class="col-md-12">
                <form action="../php/generateStudentReport.php" method="POST" role="form">
                    <center>
                        <input type="hidden" name="supervisorID" value="<?php echo $loggedInSupervisorID; ?>">
                        <button class="btn btn-warning" name="submit" type="submit">Generate Student Report</button>
                    </center>
                </form>
            </div>
        </div>

        <?php } ?>

        <br>

        <div class="row">

            <div class="col-md-12">

                <h3>Projects to Mark:</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Student ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Supervisor</th>
                            <th scope="col">Project Code</th>
                            <th scope="col">Your Mark</th>
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
                                echo '</tr>';
                            } else {

                                $showStudentsQuery = "SELECT student.studentID AS 'studentID', student.firstName AS 'firstName', student.lastName AS 'lastName', supervisor.supervisorTitle 
                                                             AS 'supervisorTitle', supervisor.firstName AS 'supervisorFirstName', supervisor.lastName AS 'supervisorLastName',
                                                             project.projectCode AS 'projectCode', student.secondaryMark as 'secondaryMark' FROM student 
                                                      INNER JOIN project ON student.projectID = project.projectID 
                                                      INNER JOIN supervisor ON supervisor.supervisorID = project.supervisorID
                                                      WHERE student.secondMarker = '$loggedInSupervisorID'";
                                $showStudentsResult = $connection->query($showStudentsQuery);

                                if ($showStudentsResult->num_rows > 0) {
                                    while($showStudentsRow = $showStudentsResult->fetch_assoc()) {
                                        $studentID = $showStudentsRow['studentID'];
                                        $firstName = $showStudentsRow['firstName'];
                                        $lastName = $showStudentsRow['lastName'];
                                        $supervisorTitle = $showStudentsRow['supervisorTitle'];
                                        $supervisorFirstName = $showStudentsRow['supervisorFirstName'];
                                        $supervisorLastName = $showStudentsRow['supervisorLastName'];
                                        $projectCode = $showStudentsRow['projectCode'];
                                        $secondaryMark = $showStudentsRow['secondaryMark'];

                                        $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;
                                        $studentName = $firstName . " " . $lastName;

                                        echo '<tr>';
                                        echo '<th scope="row">' . $studentID . '</th>';
                                        echo '<td>' . $firstName . '</td>';
                                        echo '<td>' . $lastName . '</td>';
                                        echo '<td>' . $supervisorName . '</td>';
                                        echo '<td>' . $projectCode . '</td>';
                                        if ($secondaryMark == 0 or is_null($secondaryMark)) {
                                            echo '<td>
                                                      <form action="supervisor/setsecondmark.php" method="POST" role="form">
                                                          <input type="hidden" name="studentID" value="'. $studentID .'">
                                                          <input type="hidden" name="studentName" value="'. $studentName .'">
                                                          <button class="btn btn-success" name="secondmark" type="submit">Set Mark</button>
                                                      </form>
                                                  </td>';
                                        } else {
                                            echo '<td>' . $secondaryMark . '</td>';
                                        }
                                        
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "<tr><td>No projects to mark.</td></tr>";
                                }
                            }

                            // Closes connection
                            $connection->close();

                          ?>

                    </tbody>

                </table>

            </div>

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