<!-- Page with login form -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/connect.php" ?>
    <?php include "includes/header.php" ?>
    <?php include "includes/userscript.php" ?>

    <title>Login - SPAS</title>

</head>

<body>

    <!-- Checks if user is logged in already, if so, redirect them to home page -->
    <?php
        if ($loggedIn == true) {
            header("Refresh:0.01; url=index.php");
        }
    ?>

    <header>

        <br>
        <center><h2>Login</h2></center>
        <br>
        
    </header>

    <div class="container">

        <!-- Script used to log the user into the site. -->
        <?php

            if (isset($_POST['submit'])) {

                $loginID = $_POST["loginID"];
                $loginPassword = $_POST["loginPassword"];

                $studentLoginQuery = "SELECT * FROM student WHERE studentID = '$loginID'";
                $studentLoginResult = $connection->query($studentLoginQuery);
                $supervisorLoginQuery = "SELECT * FROM supervisor WHERE supervisorID = '$loginID'";    
                $supervisorLoginResult = $connection->query($supervisorLoginQuery);
               
                if ($studentLoginResult->num_rows > 0) {
                    while($studentLoginRow = $studentLoginResult->fetch_assoc()) {
                        $passFromDB = $studentLoginRow["password"];

                        // Uses php function to check if the entered password is the same as the hashed password from the database.
                        if (password_verify($loginPassword, $passFromDB)) {
                            
                            $updateStudentQuery = "UPDATE student SET loggedIn = 1, lastIP = '$ip', lastLoggedIn = now() WHERE studentID = '$loginID'";
                            
                            if ($connection->query($updateStudentQuery) === TRUE) {
                                header("Refresh:0.01; url=../index.php");
                            } else {
                                echo "Error: " . $updateStudentQuery . "<br>" . $connection->error;
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                                        Error: Incorrect details!
                                  </div>'; 
                        } 
                    }
                } else if ($supervisorLoginResult->num_rows > 0) {
                    while($supervisorLoginRow = $supervisorLoginResult->fetch_assoc()) {
                        $passFromDB = $supervisorLoginRow["password"];

                        if (password_verify($loginPassword, $passFromDB)) {

                            $updateSupervisorQuery = "UPDATE supervisor SET loggedIn = 1, lastIP = '$ip', lastLoggedIn = now() WHERE supervisorID = '$loginID'";
                            
                            if ($connection->query($updateSupervisorQuery) === TRUE) {
                                header("Refresh:0.01; url=../index.php");
                            } else {
                                echo "Error: " . $updateSupervisorQuery . "<br>" . $connection->error;
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                                        Error: Incorrect details!
                                  </div>'; 
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Incorrect details!
                          </div>'; 
                }
            }

            $connection->close();
        ?>

        <!-- Login form contained inside a card to give it a cleaner look. -->
        <div class="card">
            <div class="card-body">

                <!-- Login form contains ID and password which is posted to the login script in the php folder. -->
                <form class="form-signin" name="loginForm" action="login.php" method="POST" enctype="multipart/form-data">

                    <div class="form-label-group">
                        <center><label>Student / Supervisor ID</label></center>
                        <input type="text" class="form-control" name="loginID" placeholder="Student or Supervisor ID" required>
                    </div>

                    <div class="form-label-group">
                        <center><label>Password</label></center>
                        <input type="password" class="form-control" name="loginPassword" placeholder="Password" required>
                    </div>

                    <br>

                    <center><button name="submit" type="submit" class="btn btn-lg btn-primary">Login</button></center>

                </form>

            </div>
        </div>
        
    </div>

</body>

</html>

