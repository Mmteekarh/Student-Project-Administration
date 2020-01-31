<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Import Students - SPAS</title>

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
    <h1 class="mt-4 mb-3">Import Students</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Import Students</li>
    </ol>

    <!-- Add Student Form -->
    <div class="row">

      <form class="form-horizontal" action="../../php/importstudents.php" method="post" name="upload_excel" enctype="multipart/form-data">

        <div class="form-group">
          <label>Select CSV File</label>
          <div class="col-md-4">
            <input type="file" name="file" id="file" class="input-large">
          </div>
        </div>
                  
        <div class="form-group">
          <div class="col-md-4">
            <button type="submit" id="submit" name="Import" class="btn btn-primary" data-loading-text="Loading...">Import</button>
          </div>
        </div>
      
      </form>
      

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

