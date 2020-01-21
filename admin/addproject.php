<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Add Project - SPAS</title>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="admin.php">Admin</a>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Back To Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="supervisor.php">Supervisor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addproject.php">Add Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="editproject.php">Edit Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="removeproject.php">Remove Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="systemmanagement.php">System Management</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Add Project</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">Add Project</li>
    </ol>

    <!-- Add Project Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Project</h3>
        <form name="projectForm" action="../php/addProject.php" method="post" enctype="multipart/form-data">
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Title</label>
              <input type="text" class="form-control" name="projectTitle" required data-validation-required-message="Project Title">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Brief</label>
              <textarea rows="10" cols="100" class="form-control" name="projectBrief" required data-validation-required-message="Project Brief" maxlength="999" style="resize:none"></textarea>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Maximum Students</label>
              <input type="text" class="form-control" name="maximumStudents" required data-validation-required-message="Maximum Students">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Project Code</label>
              <input type="text" class="form-control" name="projectCode" required data-validation-required-message="Project Code">
            </div>
          </div>
          
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
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">'.$courseName.'</label>
                                      </div>';
                            }
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $connection->error;
                    }
                    ?>  
            </div>
          </div>

          <div id="success"></div>
          <!-- For success/fail messages -->
          <button type="submit" class="btn btn-primary" id="addButton">Add</button>
        </form>
      </div>

    </div>

  </div>

  <?php include "../includes/footer.php" ?>

</body>

</html>