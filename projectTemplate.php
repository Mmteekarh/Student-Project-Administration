<!-- Page is a template for all project pages, page gets copied on project creation -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Database connection -->
    <?php include "../includes/connect.php" ?>

    <?php

        // Gets the project id from the current file name and assigns empty variables for use later.
        $projectID = basename(__FILE__, '.php');

        // Query to get the project data based on the ID.
        $query = "SELECT * FROM project where projectID='$projectID'";

        // Gets all data and assigns to variables.
        if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)){
                    $projectTitle = $row["projectTitle"];
                    $projectBrief = $row["projectBrief"];
                    $projectCode = $row["projectCode"];
                    $supervisorRow = getSupervisorDetails($connection, $row["supervisorID"]);

                    $supervisorOffice = $supervisorRow['officeNumber'];
                    $supervisorEmail = $supervisorRow['emailAddress'];

                    $supervisorTitle = $supervisorRow['supervisorTitle'];
                    $supervisorFirstName = $supervisorRow['firstName'];
                    $supervisorLastName = $supervisorRow['lastName'];
                    $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;
                }
            }
        }


        // Function uses the ID to get the supervisor name from the supervisor table.
        function getSupervisorDetails($connection, $supervisorID) {

            $row = "";
            $query = "SELECT * FROM supervisor WHERE supervisorID='" . $supervisorID . "'";

            if ($result = mysqli_query($connection, $query)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        return $row;
                    }
                }
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }

            return $row;
        }

    ?>

    <!-- Sets title to project title -->
    <title><?php echo $projectTitle; ?> - SPAS</title>

</head>

<body>

    <!-- Includes navbar -->
    <?php include "../includes/nav.php" ?>

    <!-- Main Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3"><?php echo $projectTitle; ?></h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../index.php">Project List</a>
            </li>
            <li class="breadcrumb-item active">
                <?php echo $projectTitle; ?>
            </li>
        </ol>

        <!-- Left row of content - shows project info: title, supervisor, course, project code -->
        <div class="row">

            <div class="col-md-4">
                <p><b>Title:</b> <?php echo $projectTitle; ?></p><br>
                <p><b>Supervisor:</b> <?php echo $supervisorName; ?></p><br>
                <p><b>Relevant Courses:</b> </p><br>
                <p><b>Project Code:</b> <?php echo $projectCode; ?></p>
            </div>

        </div>

        <br><hr><br>

        <!-- Right row of content - shows supervisor details -->
        <div class="row">
            <h4>Supervisor Information</h4><br>
            <p><?php echo $supervisorName; ?><br>
            <p><b>Office:</b> <?php echo $supervisorOffice; ?></p><br>
            <p><b>Email Address:</b> <?php echo $supervisorEmail; ?></p>
        </div>

        <br><hr><br>

        <!-- Bottom row of content - shows project brief -->
        <div class="row">
            <h4>Project Brief</h4><br>
            <p><?php echo $projectBrief ?>
        </div>

    </div>

    <?php $connection->close(); ?>

    <!-- Includes footer -->
    <?php include "../includes/footer.php" ?>

</body>

</html>
