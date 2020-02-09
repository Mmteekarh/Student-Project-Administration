<!-- Page shows the list of deadlines -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Deadlines - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script used to remove a deadline -->
    <?php
        
        if (isset($_POST['submit'])) {

            $deadlineID = $_POST['deadlineID'];

            $query = "DELETE FROM deadlines WHERE deadlineID='$deadlineID'";

            if ($connection->query($query) === TRUE) {
                echo '<div class="alert alert-success" role="alert">
                            Successfully removed deadline!
                      </div>';
            } else {
                 echo '<div class="alert alert-danger" role="alert">
                            Error: Could not remove deadline!
                       </div>';
            }
        }

    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Deadline Management</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item active">Deadline Management</li>
        </ol>

        <div class="row">

            <div class="col-lg-8 mb-4">

                <form action="adddeadline.php" method="POST" role="form">
                    <button class="btn btn-success" type="submit">Add New Deadline</button>
                </form>

                <br>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Deadline ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Weighting</th>
                            <th scope="col">Deadline Date</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                            $query = "SELECT * FROM deadlines";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $deadlineID = $row['deadlineID'];
                                    $deadlineName = $row['deadlineName'];
                                    $deadlineWeighting = $row['deadlineWeighting'];
                                    $deadlineDate = $row['deadlineDate'];

                                    echo '<tr>';
                                    echo '<th scope="row">' . $deadlineID . '</th>';
                                    echo '<td>' . $deadlineName . '</td>';
                                    echo '<td>' . $deadlineWeighting . '</td>';
                                    echo '<td>' . $deadlineDate . '</td>';
                                    echo '<td>
                                            <form action="editingdeadline.php" method="POST" role="form">
                                            <input type="hidden" name="deadlineID" value="' . $deadlineID . '">
                                            <button class="btn btn-primary" type="submit">Edit</button></form>
                                          </td>';
                                    echo '<td>
                                            <form action="deadlines.php" method="POST" role="form">
                                            <input type="hidden" name="deadlineID" value="' . $deadlineID . '">
                                            <button class="btn btn-danger" name="submit" type="submit">Remove</button></form>
                                          </td>';
                                    echo '</tr>';
                                }
                            } else {
                                 echo '<div class="alert alert-danger" role="alert">
                                            Error: Could not retrieve deadline data - No records found. 
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