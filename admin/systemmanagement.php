<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Admin - SPAS</title>

</head>

<body>

  <?php
      if ($loggedIn == true) {
            if ($userType == "admin") {
  ?>

  <!-- Includes navigation bar -->
  <?php include "../includes/systemnav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <h1 class="mt-4 mb-3">System Management</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">System Management</li>
    </ol>

  </div>
  <!-- /.container -->

  <?php include "../includes/footer.php" ?>

  <?php
        
          } else if ($userType == "student" or $userType == "supervisor") {
            // Invalid Permissions
            header("Refresh:0.01; url=../error/permissionerror.php");

          } else {
              // Invalid user type
              header("Refresh:0.01; url=../error/usertypeerror.php");
          }
        } else {
            header("Refresh:0.01; url=../login.php");
        }
    ?>

</body>

</html>