<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Edit Project - SPAS</title>

</head>

<body>

  <!-- Includes navigation bar -->
  <?php include "../../includes/supervisornav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Edit Project</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="admin.php">Supervisor Tools</a>
      </li>
      <li class="breadcrumb-item active">Edit Project</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Edit Project</h3>

        <?php
          $query = "SELECT * FROM project";

          if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  $projectTitle = $row["projectTitle"];
                  $projectID = $row["projectID"];
                  echo $projectTitle;
                  echo "<br>";
                  echo '<form action="editingproject.php" method="post" role="form">';
                  echo '<input type="hidden" name="projectID" value="'. $projectID .'">';
                  echo '<button type="submit">Edit</button></form>'; 
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

</body>

</html>