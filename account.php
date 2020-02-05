<!-- Page shows account details and allow user to change password and view information -->
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Database connection and title -->
	<?php include "includes/connect.php" ?>
  <title>Account - SPAS</title>

  <?php

    if ($userType == "student") {

      $studentQuery = "SELECT * FROM student WHERE studentID='$studentID'";

      if ($result = mysqli_query($connection, $studentQuery)) {
          if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)){
                $studentFirstName = $row["firstName"];
                $studentMiddleInitial = $row["middleInitial"];
                $studentLastName = $row["lastName"];
                $studentYearOfStudy = $row["yearOfStudy"];
                $user = "Student";
              }
          }
      }

    } else if ($userType == "supervisor" or $userType == "admin") {

      $supervisorQuery = "SELECT * FROM supervisor WHERE supervisorID='$supervisorID'";

      if ($result = mysqli_query($connection, $supervisorQuery)) {
          if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)){
                $supervisorFirstName = $row["firstName"];
                $supervisorLastName = $row["lastName"];
                $supervisorEmailAddress = $row["emailAddress"];
                $supervisorOfficeNumber = $row["officeNumber"];
                if ($row["admin"] == 1) {
                  $user = "Administrator";
                } else {
                  $user = "Supervisor";
                }
              }
          }
      }
    }

  ?>

</head>

<body>

  <?php
      if ($loggedIn == true) {
            if ($userType == "student" or $userType == "admin" or $userType == "supervisor") {
  ?>

	<!-- Includes navbar -->
	<?php include "includes/nav.php" ?>

  	<!-- Page Content -->
  	<div class="container">

  	  	<!-- Page Header -->
  	    <br>
  	    <h2>My Account</h2>
  	    <br>

  	    <div class="row">

          <div class="col-md-6 border">

            <br>

    	    	<form name="changePassword" action="php/changePassword.php" method="post" enctype="multipart/form-data">

              <input type="hidden" class="form-control" name="userType" value="<?php echo $userType; ?>">

    	    	    <div class="control-group form-group">
                		<div class="controls">
                  	    <label>Current Password</label>
                  			<input type="password" class="form-control" name="currentPassword" required>
                		</div>
              		</div>

              		<div class="control-group form-group">
                		<div class="controls">
                  			<label>New Password</label>
                  			<input type="password" class="form-control" name="newPassword" required>
                		</div>
              		</div>

              		<div class="control-group form-group">
                		<div class="controls">
                  			<label>Confirm New Password</label>
                  			<input type="password" class="form-control" name="confirmNewPassword" required>
                		</div>
              		</div>

              		<button type="submit" class="btn btn-primary" id="changePasswordButton">Change Password</button>
            </form>
            <br>

          </div>

          <div class="col-md-6 border">
            <br>
            <h4>Account Details</h4>
            <br>
            <?php 
              if ($userType == "student") {
                echo "<b>First Name: </b>" . $studentFirstName;
                echo "<br><b>Middle Initial: </b>" . $studentMiddleInitial;
                echo "<br><b>Last Name: </b>" . $studentLastName;
                echo "<br><b>Year of Study: </b>" . $studentYearOfStudy;
                echo "<br><b>User Type: </b>" . $user;
              } else if ($userType == "supervisor" or $userType == "admin") {
                echo "<b>First Name: </b>" . $supervisorFirstName;
                echo "<br><b>Last Name: </b>" . $supervisorLastName;
                echo "<br><b>Email Address: </b>" . $supervisorEmailAddress;
                echo "<br><b>Office Number: </b>" . $supervisorOfficeNumber;
                echo "<br><b>User Type: </b>" . $user;

              } else {
                // Invalid user type
                header("Refresh:0.01; url=error/usertypeerror.php");
              }
            ?>

            <br>

            <p><em><small>If these details are incorrect, please contact an administrator</small></em></p>

            <br>

          </div>

  	    </div>

	  </div>

	<br><br>
  
  	<!-- Includes footer -->
	<?php include "includes/footer.php" ?>

  <?php
        
          } else {
              // Invalid user type
              header("Refresh:0.01; url=error/usertypeerror.php");
          }
        } else {
            header("Refresh:0.01; url=login.php");
        }
    ?>

</body>

</html>

