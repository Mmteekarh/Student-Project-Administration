<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../includes/connect.php" ?>
  <title>Add Supervisor - SPAS</title>

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
    <h1 class="mt-4 mb-3">Add Supervisor</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="admin.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Add Supervisor</li>
    </ol>

    <!-- Add Supervisor Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Supervisor</h3>
        <form name="supervisorForm" action="../php/addSupervisor.php" method="post" enctype="multipart/form-data">
          <div class="control-group form-group">
            <div class="controls">
              <label>Supervisor Title</label>
              <input type="text" class="form-control" name="supervisorTitle" required data-validation-required-message="Supervisor Title">
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

          <button type="submit" class="btn btn-primary" id="addButton">Add</button>
          
        </form>
      </div>

    </div>

  </div>

  <?php include "../includes/footer.php" ?>

</body>

</html>