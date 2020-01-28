<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Remove Project - SPAS</title>

</head>

<body>

    <?php
      if ($loggedIn == true) {
            if ($userType == "supervisor" or $userType == "admin") {
  ?>

  <!-- Includes navigation bar -->
  <?php include "../../includes/supervisornav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Remove Project</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../supervisor.php">Supervisor Tools</a>
      </li>
      <li class="breadcrumb-item active">Remove Project</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Project</h3>

        <?php
          $query = "SELECT * FROM project WHERE supervisorID='$supervisorID'";

          if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  $projectTitle = $row["projectTitle"];
                  $projectID = $row["projectID"];
                  echo $projectTitle;
                  echo "<br>";
                  echo '<form action="../../php/removeProject.php" method="post" role="form">';
                  echo '<input type="hidden" name="projectID" value="'. $projectID .'">';
                  echo '<button type="submit">Remove</button></form>'; 
                  echo "<br>";
              }
            }
          }

          $connection->close();
        ?>

      </div>
    </div>

  </div>

  <?php include "../../includes/footer.php" ?>

      <?php
        
          } else if ($userType == "student") {
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