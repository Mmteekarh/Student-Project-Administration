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
                            <h4>Allocate Projects</h4>

                            <!-- Form posts to php scripts which allocates student projects -->
                            <form action="../php/allocateProjects.php" method="POST" role="form">
                                <button class="btn btn-danger" type="submit">ALLOCATE</button>
                            </form>
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
                            <h1>0</h1>
                            <h2>Students chosen projects</h2>
                        </center>
                    </div>
                </div>
            </div>

        </div>

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