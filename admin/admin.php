<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Admin - SPAS</title>

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

    <h1 class="mt-4 mb-3">Admin - Home</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">Home</li>
    </ol>

  </div>
  <!-- /.container -->

  <?php include "../includes/footer.php" ?>

</body>

</html>