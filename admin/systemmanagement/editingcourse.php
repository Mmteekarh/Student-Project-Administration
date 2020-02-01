<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Editing Course - SPAS</title>

  <?php

    $courseID = $_POST['courseID'];
    $courseName;
    $courseLevel;
    $courseLeader;
  
    $query = "SELECT * FROM course WHERE courseID='$courseID'";

    if ($result = mysqli_query($connection, $query)) {
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $courseName = $row["courseName"];
          $courseLevel = $row["courseLevel"];
          $courseLeader = $row["courseLeader"];
        }
      }
    }

  ?>

</head>

<body>

  <?php
      if ($loggedIn == true) {
            if ($userType == "admin") {
  ?>

  <!-- Includes navigation bar -->
  <?php include "../../includes/systemnav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Editing Course</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemnav.php">System Management</a>
      </li>
      <li class="breadcrumb-item">
        <a href="courselist.php">Course List</a>
      </li>
      <li class="breadcrumb-item active">Editing Course</li>
    </ol>

    <!-- Editing Course Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Editing Course</h3>
        <form name="supervisorForm" action="../../php/editCourse.php" method="post" enctype="multipart/form-data">

          <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">

          <div class="control-group form-group">
            <div class="controls">
              <label>Course Name</label>
              <input type="text" class="form-control" name="courseName" value="<?php echo $courseName; ?>" required data-validation-required-message="Course Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Course Level</label>
              <input type="text" class="form-control" name="courseLevel" value="<?php echo $courseLevel; ?>" required data-validation-required-message="Course Level">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Course Leader</label>
              <input type="text" class="form-control" name="courseLeader" value="<?php echo $courseLeader; ?>" required data-validation-required-message="Course Leader">
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary" id="addButton">Edit</button>
          
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

