<!-- Page shows a list of students. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Student List - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script that removes students from the database -->
    <?php
        if (isset($_POST['submit'])) {

            $studentID = $_POST['studentID'];

            $query = "DELETE FROM student WHERE studentID='$studentID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully removed student!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove student!
                       </div>';
            }
        }

    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Student List</h1>
        </center>

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

            <div class="col-md-12">

                <form action="addstudent.php" method="POST" role="form">
                    <button class="btn btn-success" type="submit">Add New Student</button>
                </form>

                <br>

                <form action="importstudents.php" method="POST" role="form">
                  <button class="btn btn-success" type="submit">Import Students</button>
                </form>

                <br>

                <table class="table table-striped">
                    <thead>
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
                    </thead>

                    <tbody>

                        <?php

                            $query = "SELECT * FROM student INNER JOIN course ON student.courseID = course.courseID";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $studentID = $row['studentID'];
                                    $firstName = $row['firstName'];
                                    $middleInitial = $row['middleInitial'];
                                    $lastName = $row['lastName'];
                                    $yearOfStudy = $row['yearOfStudy'];
                                    $plp = $row['plp'];
                                    $loggedIn = $row['loggedIn'];
                                    $lastIP = $row['lastIP'];

                                    if (is_null($row['courseName'])) {
                                        $courseName = "No Course";
                                    } else {
                                        $courseName = $row['courseName'];
                                    }

                                    if ($plp == 1) {
                                        $plpText = "Yes";
                                    } else {
                                        $plpText = "No";
                                    }

                                    if ($loggedIn == 1) {
                                        $loggedInText = "Yes";
                                    } else {
                                        $loggedInText = "No";
                                    }

                                    echo '<tr>';
                                    echo '<th scope="row">' . $studentID . '</th>';
                                    echo '<td>' . $firstName . '</td>';
                                    echo '<td>' . $middleInitial . '</td>';
                                    echo '<td>' . $lastName . '</td>';
                                    echo '<td>' . $yearOfStudy . '</td>';
                                    echo '<td>' . $plpText . '</td>';
                                    echo '<td>' . $courseName . '</td>';
                                    echo '<td>' . $loggedInText . '</td>';
                                    echo '<td>' . $lastIP . '</td>';
                                    echo '<td>
                                              <form action="editingstudent.php" method="POST" role="form">
                                                  <input type="hidden" name="studentID" value="'. $studentID .'">
                                                  <button class="btn btn-primary" type="submit">Edit</button>
                                              </form>
                                          </td>';
                                    echo '<td>
                                              <form action="studentlist.php" method="POST" role="form">
                                                  <input type="hidden" name="studentID" value="'. $studentID .'">
                                                  <button class="btn btn-danger" name="submit" type="submit">Remove</button>
                                              </form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                 echo '<tr><td>No students! Add some using the buttons above.</td></tr>';
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