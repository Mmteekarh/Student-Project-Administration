<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Editing Deadline - SPAS</title>

  <?php

    $deadlineID = $_POST['deadlineID'];
    $deadlineName;
    $deadlineWeighting;
    $deadlineDate;
  
    $query = "SELECT * FROM deadlines WHERE deadlineID='$deadlineID'";

    if ($result = mysqli_query($connection, $query)) {
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $deadlineName = $row["deadlineName"];
          $deadlineWeighting = $row["deadlineWeighting"];
          $deadlineDate = $row["deadlineDate"];
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
    <h1 class="mt-4 mb-3">Editing Deadline</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemnav.php">System Management</a>
      </li>
      <li class="breadcrumb-item">
        <a href="deadlines.php">Deadline Management</a>
      </li>
      <li class="breadcrumb-item active">Editing Deadline</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Editing Deadline</h3>
        <form name="deadlineForm" action="../../php/editDeadline.php" method="post" enctype="multipart/form-data">

          <input type="hidden" name="deadlineID" value="<?php echo $deadlineID; ?>">

          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Name</label>
              <input type="text" class="form-control" name="deadlineName" value="<?php echo $deadlineName; ?>" required data-validation-required-message="Deadline Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Weighting</label>
              <input type="text" class="form-control" name="deadlineWeighting" value="<?php echo $deadlineWeighting; ?>" required data-validation-required-message="Deadline Weighting">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Date</label>
              <input type="text" class="form-control" name="deadlineDate" value="<?php echo $deadlineDate; ?>" required data-validation-required-message="Deadline Date">
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

