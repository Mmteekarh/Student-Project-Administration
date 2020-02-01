<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Editing Student - SPAS</title>

  <?php

    $stuID = $_POST['stuID'];
    $middleInitial;
    $firstName;
    $lastName;
    $yearOfStudy;
    $plp;

    $query = "SELECT * FROM student WHERE studentID='$stuID'";

    if ($result = mysqli_query($connection, $query)) {
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $middleInitial = $row["middleInitial"];
          $firstName = $row["firstName"];
          $lastName = $row["lastName"];
          $yearOfStudy = $row["yearOfStudy"];
          $plp = $row["plp"];
        }
      }
    }

  ?>

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
    <h1 class="mt-4 mb-3">Editing Student</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemnav.php">System Management</a>
      </li>
      <li class="breadcrumb-item">
        <a href="editstudent.php">Edit Student</a>
      </li>
      <li class="breadcrumb-item active">Editing Student</li>
    </ol>

    <!-- Editing Student Form -->
    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Editing Student</h3>
        <form name="studentForm" action="../../php/editStudent.php" method="post" enctype="multipart/form-data">
          
          <input type="hidden" name="stuID" value="<?php echo $stuID; ?>">

          <div class="control-group form-group">
            <div class="controls">
              <label>First Name</label>
              <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>" required data-validation-required-message="First Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Middle Initial</label>
              <input type="text" class="form-control" name="middleInitial" value="<?php echo $middleInitial; ?>">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Last Name</label>
              <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>" required data-validation-required-message="Last Name">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>Year of Study</label>
              <input type="text" class="form-control" name="yearOfStudy" value="<?php echo $yearOfStudy; ?>" required data-validation-required-message="Year of study">
            </div>
          </div>
          <div class="control-group form-group">
            <div class="controls">
              <label>PLP</label>
              <input type="text" class="form-control" name="plp" value="<?php echo $plp; ?>" required data-validation-required-message="PLP">
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

          <button type="submit" class="btn btn-primary" id="editButton">Edit</button>
          
        </form>
      </div>

    </div>

  </div>

  <?php include "../../includes/footer.php" ?>

    <?php
        
          } else if ($userType == "supervisor" or $userType == "student") {
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

