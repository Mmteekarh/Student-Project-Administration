<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Add Deadline - SPAS</title>

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
    <h1 class="mt-4 mb-3">Add Deadline</h1>

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
      <li class="breadcrumb-item active">Add Deadline</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Deadline</h3>
        <form name="deadlineForm" action="../../php/addDeadline.php" method="post" enctype="multipart/form-data">

          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Name</label>
              <input type="text" class="form-control" name="deadlineName" placeholder="For example: 1CWK50" required data-validation-required-message="Deadline Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Weighting</label>
              <input type="text" class="form-control" name="deadlineWeighting" placeholder="For example: 50" required data-validation-required-message="Deadline Weighting">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Deadline Date</label>
              <input type="text" class="form-control" name="deadlineDate" placeholder="For example: 10/10/20" required data-validation-required-message="Deadline Date">
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