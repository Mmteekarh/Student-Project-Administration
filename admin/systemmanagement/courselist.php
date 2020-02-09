<!-- Page shows a list of courses with the option to edit and remove -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Course List - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script used to remove a course -->
    <?php
        if (isset($_POST['submit'])) {

            $courseID = $_POST['courseID'];

            $query = "DELETE FROM course WHERE courseID = '$courseID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully removed course!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove course!
                       </div>';
            }
        }


    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Course List</h1>
        </center>

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

                <form action="addcourse.php" method="POST" role="form">
                    <button class="btn btn-success" type="submit">Add New Course</button>
                </form>

                <br>

                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">Course ID</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Course Level</th>
                            <th scope="col">Course Leader</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                            $query = "SELECT * FROM course";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
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
                                              <form action="courselist.php" method="post" role="form">
                                              <input type="hidden" name="courseID" value="'. $courseID .'">
                                              <button class="btn btn-danger" name="submit" type="submit">Remove</button></form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                            Error: Could not retrieve project course data - No records found. 
                                      </div>';
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