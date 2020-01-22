<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Remove Project - SPAS</title>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="admin.php">Admin</a>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Back To Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="supervisor.php">Supervisor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addproject.php">Add Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="editproject.php">Edit Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="removeproject.php">Remove Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="systemmanagement.php">System Management</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Remove Project</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">Remove Project</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Project</h3>

        <?php
          $query = "SELECT * FROM project";

          if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  $projectTitle = $row["projectTitle"];
                  $projectID = $row["projectID"];
                  echo $projectTitle;
                  echo "<br>";
                  echo '<form action="../php/removeProject.php" method="post" role="form">';
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

  <?php include "../includes/footer.php" ?>

</body>

</html>