<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Add Student - SPAS</title>

</head>

<body>

  <!-- Includes navigation bar -->
  <?php include "../../includes/systemnav.php" ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Add Student</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="admin.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Add Student</li>
    </ol>

    <!-- Add Student Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Add Student</h3>
        <form name="studentForm" action="../../php/addStudent.php" method="post" enctype="multipart/form-data">
          <div class="control-group form-group">
            <div class="controls">
              <label>Student ID</label>
              <input type="text" class="form-control" name="studentID" required data-validation-required-message="Student ID">
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
              <label>Middle Initial</label>
              <input type="text" class="form-control" name="middleInitial">
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
              <label>Year of Study</label>
              <input type="text" class="form-control" name="yearOfStudy" required data-validation-required-message="Year of study">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>PLP</label>
              <input type="text" class="form-control" name="plp" required data-validation-required-message="PLP">
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

  <?php include "../../includes/footer.php" ?>

</body>

</html>