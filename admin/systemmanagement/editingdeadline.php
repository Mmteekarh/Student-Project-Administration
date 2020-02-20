<!-- Page used by admin to edit deadlines -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Editing Deadline - SPAS</title>

    <?php

        $deadlineID = $_POST['deadlineID'];
      
        $query = "SELECT * FROM deadlines WHERE deadlineID='$deadlineID'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $deadlineName = $row["deadlineName"];
                $deadlineWeighting = $row["deadlineWeighting"];
                $deadlineDate = $row["deadlineDate"];
            }
        }

    ?>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script used to edit deadlines -->
    <?php

        $editedDeadlineName = $editedDeadlineWeighting = $editedDeadlineDate = "";

        if (isset($_POST['submit'])) {

            $editedDeadlineName = $_POST['deadlineName'];
            $editedDeadlineWeighting = $_POST['deadlineWeighting'];
            $editedDeadlineDate = $_POST['deadlineDate'];

            $query = "UPDATE deadlines SET deadlineName='$editedDeadlineName', deadlineWeighting='$editedDeadlineWeighting', deadlineDate='$editedDeadlineDate', lastUpdated = now() WHERE deadlineID='$deadlineID'";

            if ($connection->query($query) === TRUE) {
                header("Refresh:0.01; url=deadlines.php");
            } else {
                echo '<div class="alert alert-danger" role="alert">
                            Error: Could not update deadline!
                      </div>'; 
            }

        }

        $connection->close();

    ?>

    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Editing Deadline</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="deadlines.php">Deadline Management</a>
            </li>
            <li class="breadcrumb-item active">Editing Deadline</li>
        </ol>

        <div class="row">

            <div class="col-lg-8 mb-4">

                <form name="editDeadlineForm" action="editingdeadline.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="deadlineID" value="<?php echo $deadlineID; ?>">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Deadline Name</label>
                            <input type="text" class="form-control" name="deadlineName" value="<?php echo $deadlineName; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Deadline Weighting</label>
                            <input type="text" class="form-control" name="deadlineWeighting" value="<?php echo $deadlineWeighting; ?>" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Deadline Date</label>
                            <input type="text" class="form-control" name="deadlineDate" value="<?php echo $deadlineDate; ?>" required>
                        </div>
                    </div>
          
                    <button type="submit" name="submit" class="btn btn-primary" id="editButton">Edit</button>
          
                </form>

            </div>

        </div>

    </div>

    <?php include "../../includes/footer.php" ?>

    <?php
        
            } else if ($userType == "supervisor" or $userType == "student") {
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