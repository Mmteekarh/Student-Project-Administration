<!DOCTYPE html>
<html lang="en">

<head>

  <?php include "../../includes/connect.php" ?>
  <title>Remove Student - SPAS</title>

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
    <h1 class="mt-4 mb-3">Remove Student</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="../admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item">
        <a href="../systemmanagement.php">System Management</a>
      </li>
      <li class="breadcrumb-item active">Remove Student</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Student</h3>

        <?php
          $query = "SELECT * FROM student";

          if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  $firstName = $row["firstName"];
                  $lastName = $row["lastName"];
                  $studentID = $row["studentID"];
  
                  echo $firstName . " " . $lastName . " (" . $studentID . ")";
                  echo "<br>";
                  echo '<form action="../../php/removeStudent.php" method="post" role="form">';
                  echo '<input type="hidden" name="studentID" value="'. $studentID .'">';
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