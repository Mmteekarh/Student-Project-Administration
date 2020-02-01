<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Add Course - SPAS</title>

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
    <h1 class="mt-4 mb-3">Add Course</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item">
        <a href="courselist.php">Course List</a>
      </li>
      <li class="breadcrumb-item active">Add Course</li>
    </ol>

    <!-- Add Course Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Course</h3>
        <form name="courseForm" action="../../php/addCourse.php" method="post" enctype="multipart/form-data">

          <div class="control-group form-group">
            <div class="controls">
              <label>Course ID</label>
              <input type="text" class="form-control" name="courseID" required data-validation-required-message="Course ID">
            </div>
          </div>

          <div class="control-group form-group">
            <div class="controls">
              <label>Course Name</label>
              <input type="text" class="form-control" name="courseName" required data-validation-required-message="Course Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Course Level</label>
              <input type="text" class="form-control" name="courseLevel" required data-validation-required-message="Course Level">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Course Leader</label>
              <input type="text" class="form-control" name="courseLeader" required data-validation-required-message="Course Leader">
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary" id="addButton">Add</button>
          
        </form>
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