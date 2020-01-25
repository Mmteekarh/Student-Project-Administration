<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Editing Project - SPAS</title>

  <?php

    $projectID = $_POST['projectID'];
    $projectTitle;
    $projectBrief;
    $projectCode;
    $maximumStudents;

    $query = "SELECT * FROM project WHERE projectID='$projectID'";

    if ($result = mysqli_query($connection, $query)) {
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $projectTitle = $row["projectTitle"];
          $projectBrief = $row["projectBrief"];
          $projectCode = $row["projectCode"];
          $maximumStudents = $row["maximumStudents"];
        }
      }
    }

  ?>

</head>

<body>

  <!-- Includes navigation bar -->
  <?php include "../../includes/supervisornav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Editing Project</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="admin.php">Supervisor Tools</a>
      </li>
      <li class="breadcrumb-item">
        <a href="admin.php">Edit Project</a>
      </li>
      <li class="breadcrumb-item active">Editing Project</li>
    </ol>

    <!-- Editing Project Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Editing Project</h3>
        <form name="projectForm" action="../../php/editProject.php" method="post" enctype="multipart/form-data">
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Title</label>
              <input type="text" class="form-control" name="projectTitle" placeholder="<?php echo $projectTitle; ?>" required data-validation-required-message="Project Title">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Brief</label>
              <textarea rows="10" cols="100" class="form-control" name="projectBrief" placeholder="<?php echo $projectBrief; ?>" required data-validation-required-message="Project Brief" maxlength="999" style="resize:none"></textarea>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Maximum Students</label>
              <input type="text" class="form-control" name="maximumStudents" placeholder="<?php echo $maximumStudents; ?>" required data-validation-required-message="Maximum Students">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Code</label>
              <input type="text" class="form-control" name="projectCode" placeholder="<?php echo $projectCode; ?>" required data-validation-required-message="Project Code">
            </div>
          </div>

          <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
          
          <div class="control-group form-group">
            <div class="controls">
              <?php
                    $query = "SELECT * FROM course";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $courseName = $row['courseName'];
                                $courseID = $row['courseID'];

                                echo '<div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="courses[]" value="'.$courseID.'">
                                        <label class="form-check-label" for="courses[]">'.$courseName.'</label>
                                      </div>';
                            }
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $connection->error;
                    }

                    $connection->close();
                    ?>  
            </div>
          </div>

          <div id="success"></div>
          <!-- For success/fail messages -->
          <button type="submit" class="btn btn-primary" id="addButton">Edit</button>
        </form>
      </div>

    </div>

  </div>

  <?php include "../../includes/footer.php" ?>

</body>

</html>

