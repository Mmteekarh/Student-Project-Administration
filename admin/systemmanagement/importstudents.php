<!-- Page used for importing a CSV file of students -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "../../includes/header.php" ?>
    <?php include "../../includes/userscript.php" ?>
    <?php include "../../includes/connect.php" ?>

    <title>Import Students - SPAS</title>

</head>

<body>

    <!-- Ensures admin is logged in -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "admin") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "../../includes/systemnav.php" ?>

    <!-- Script used to insert students via a CSV file -->
    <?php

        // Check if a file has been posted and get its name.
        if(isset($_POST["Import"])) {
            $filename = $_FILES["file"]["tmp_name"]; 

            // Check if the file has any data and opens it.
            if($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");

                $i = 0;

                // Loops through each line of the file using the comma as a separator, gets each field and stores in a variable.
                while (($data = fgetcsv($file, 0, ",")) !== FALSE) {

                    // Ignores first line of CSV file.
                    if($i == 0) { 
                        $i++; 
                        continue; 
                    } 
                    
                    $studentID = $data[0];
                    $firstName = $data[1];
                    $middleInitial = $data[2];
                    $lastName = $data[3];
                    $yearOfStudy = $data[4];
                    $plp = $data[5];
                    $password = $data[6];
                    $courseID = $data[7];

                    // Used built-in php function to hash the password.
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password, courseID, dateCreated, lastUpdated) VALUES ($studentID, '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', $plp, '$hashedPassword', $courseID, now(), now())";

                    // If query executed correctly, refresh to student page. If not, display an error.
                    if (!($connection->query($query) == TRUE)) {
                        echo '<div class="alert alert-danger" role="alert">
                                Error: Cannot insert students! 
                              </div>';             
                    } else {
                    	header("Refresh:0.01; url=studentlist.php");
                    }

                }
            } else {
            	// Error runs if there was not a file uploaded or the file type was incorrect.
                echo '<div class="alert alert-danger" role="alert">
                            Error: No file was selected! 
                      </div>';       
            }
        }

        $connection->close();

    ?>



    <!-- Page content includes add course form. -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <center>
            <h1 class="mt-4 mb-3">Import Students</h1>
        </center>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="../systemmanagement.php">System Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="studentlist.php">Student List</a>
            </li>
            <li class="breadcrumb-item active">Import Students</li>
        </ol>

        <!-- Main content for import students form. -->
        <div class="row">

            <form class="form-horizontal" action="importstudents.php" method="post" name="upload_excel" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Select CSV File</label>
                    <div class="col-md-4">
                        <input type="file" name="file" id="file" class="input-large">
                    </div>
                </div>
                  
                <div class="form-group">
                    <div class="col-md-4">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary" data-loading-text="Loading...">Import</button>
                    </div>
                </div>
      
            </form>

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