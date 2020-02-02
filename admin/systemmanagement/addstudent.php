<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Add Student - SPAS</title>

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
    <h1 class="mt-4 mb-3">Add Student</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
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
              <select name="yearOfStudy">
                <option value="2019/2020">2019/2020</option>
                <option value="2020/2021">2020/2021</option>
              </select>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>PLP</label>
              <select name="plp">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Password</label>
              <input type="text" class="form-control" name="password" required data-validation-required-message="Password">
            </div>
          </div>

          <div class="control-group form-group">
            <div class="controls">
              <label>Course</label>
                <select name="courseID">
                <?php

                    $query = "SELECT * FROM course";

                    if ($result = mysqli_query($connection, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)){
                                $courseName = $row['courseName'];
                                $courseID = $row['courseID'];

                                echo '<option value="'.$courseID.'">' . $courseName . '</option>';
                            }
                        }
                    } else {
                        echo "Error: " . $query . "<br>" . $connection->error;
                    }
                ?>
                </select>
              </div>
          </div>

          <button type="submit" class="btn btn-primary" id="addButton">Add</button>
          
        </form>
      </div>

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