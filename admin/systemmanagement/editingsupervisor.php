<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Editing Supervisor - SPAS</title>

  <?php

    $superID = $_POST['superID'];
    $supervisorTitle;
    $firstName;
    $lastName;
    $activeSupervisor;
    $officeNumber;
    $emailAddress;
    $admin;

    $query = "SELECT * FROM supervisor WHERE supervisorID='$superID'";

    if ($result = mysqli_query($connection, $query)) {
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $supervisorTitle = $row["supervisorTitle"];
          $firstName = $row["firstName"];
          $lastName = $row["lastName"];
          $activeSupervisor = $row["activeSupervisor"];
          $officeNumber = $row["officeNumber"];
          $emailAddress = $row["emailAddress"];
          $admin = $row["admin"];
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
    <h1 class="mt-4 mb-3">Editing Supervisor</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemnav.php">System Management</a>
      </li>
      <li class="breadcrumb-item">
        <a href="editsupervisor.php">Edit Supervisor</a>
      </li>
      <li class="breadcrumb-item active">Editing Supervisor</li>
    </ol>

    <!-- Editing Supervisor Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Editing Supervisor</h3>
        <form name="supervisorForm" action="../../php/editSupervisor.php" method="post" enctype="multipart/form-data">

          <input type="hidden" name="superID" value="<?php echo $superID; ?>">

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
              <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>" required data-validation-required-message="First Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Last Name</label>
              <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>" required data-validation-required-message="Last Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Office Number</label>
              <input type="text" class="form-control" name="officeNumber" value="<?php echo $officeNumber; ?>" required data-validation-required-message="Office Number">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Email Address</label>
              <input type="text" class="form-control" name="emailAddress" value="<?php echo $emailAddress; ?>" required data-validation-required-message="Email Address">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="form-check">
              <label>Active Supervisor?</label><br>
              <label class="radio-inline"><input value="Yes" type="radio" name="activeSupervisor" checked>Yes</label>
              <label class="radio-inline"><input value="No" type="radio" name="activeSupervisor">No</label>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="form-check">
              <label>System Administrator?</label><br>
              <label class="radio-inline"><input value="Yes" type="radio" name="admin">Yes</label>
              <label class="radio-inline"><input value="No" type="radio" name="admin" checked>No</label>
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

