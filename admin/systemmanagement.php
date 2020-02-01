<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Admin - SPAS</title>

  <?php
    $deadlineQuery = "SELECT COUNT(*) AS deadlines FROM deadlines";

    if ($result = mysqli_query($connection, $deadlineQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $deadlineNumber = $row["deadlines"];
            }
        }
    }

    $connection->close();

  ?>

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

    <div class="row">

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h4>Allocate Projects</h4>
              <form action="allocateProjects.php" method="post" role="form">
              <button class="btn btn-danger" type="submit">ALLOCATE</button>
              </form>
            </center>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h1><?php echo $deadlineNumber; ?></h1>
              <h2>Deadlines</h2>
            </center>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <center>
              <h1>0</h1>
              <h2>Students chosen projects</h2>
            </center>
          </div>
        </div>
      </div>

    </div>

  </div>

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