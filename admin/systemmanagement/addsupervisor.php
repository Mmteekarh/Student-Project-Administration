<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Add Supervisor - SPAS</title>

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
    <h1 class="mt-4 mb-3">Add Supervisor</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Add Supervisor</li>
    </ol>

    <!-- Add Supervisor Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Supervisor</h3>
        <form name="supervisorForm" action="../../php/addSupervisor.php" method="post" enctype="multipart/form-data">
          <div class="control-group form-group">
            <div class="controls">
              <label>Supervisor Title</label>
              <select name="supervisorTitle">
                <option>Dr</option>
                <option>Professor</option>
                <option>Mr</option>
                <option>Mrs</option>
                <option>Miss</option>
              </select>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>First Name</label>
              <input type="text" class="form-control" name="firstName" required data-validation-required-message="First Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Last Name</label>
              <input type="text" class="form-control" name="lastName" required data-validation-required-message="Last Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Office Number</label>
              <input type="text" class="form-control" name="officeNumber" required data-validation-required-message="Office Number">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Email Address</label>
              <input type="text" class="form-control" name="emailAddress" required data-validation-required-message="Email Address">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Password</label>
              <input type="text" class="form-control" name="password" required data-validation-required-message="Password">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="form-check">
              <label>Active Supervisor?</label><br>
              <label class="radio-inline"><input value="Yes" type="radio" name="activeSupervisor" checked>Yes</label>
              <label class="radio-inline"><input value="No" type="radio" name="activeSupervisor">No</label>
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