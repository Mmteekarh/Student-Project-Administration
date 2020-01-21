<!-- Page is a template for all project pages, page gets copied on project creation -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Database connection -->
    <?php include "../includes/connect.php" ?>

    <?php

        // Gets the project id from the current file name and assigns empty variables for use later.
        $projectID = basename(__FILE__, '.php');
        $projectTitle = "";
        $projectBrief = "";
        $projectCode = "";
        $supervisorName = "";

        // Query to get the project data based on the ID.
        $query = "SELECT * FROM project where projectID='$projectID'";

        // Gets all data and assigns to variables.
        if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)){
                    $projectTitle = $row["projectTitle"];
                    $projectBrief = $row["projectBrief"];
                    $projectTitle = $row["projectCode"];
                    $supervisorName = getSupervisorName($connection, $row["supervisorID"]);
                }
            }
        }


        // Function uses the ID to get the supervisor name from the supervisor table.
        function getSupervisorName($connection, $supervisorID) {

            $supervisorName = "";
            $query = "SELECT * FROM supervisor WHERE supervisorID='" . $supervisorID . "'";

            if ($result = mysqli_query($connection, $query)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $supervisorTitle = $row['supervisorTitle'];
                        $supervisorFirstName = $row['firstName'];
                        $supervisorLastName = $row['lastName'];
                        $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;
                    }
                }
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }

            return $supervisorName;
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
                <h2>Title: <?php echo $projectTitle; ?></h2>
                <h2>Supervisor: <?php echo $supervisorName; ?></h2>
                <h2>Relevant Courses: </h2>
                <h2>Project Code: <?php echo $projectCode; ?></h2>
            </div>

        </div>

        <br><hr><br>

        <!-- Right row of content - shows supervisor details -->
        <div class="row">
            <h3>Supervisor Information</h3>
            <p><?php echo $supervisorName ?>
            <p>Office:</p>
            <p>Email Address:</p>
        </div>

        <br><hr><br>

        <!-- Bottom row of content - shows project brief -->
        <div class="row">
            <h3>Project Brief</h3>
            <p><?php echo $projectBrief ?>
        </div>

    </div>

    <?php $connection->close(); ?>

    <!-- Includes footer -->
    <?php include "../includes/footer.php" ?>

</body>

</html>
