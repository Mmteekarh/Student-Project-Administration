<!-- Script used to log the user into the site. -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $loginID = $_POST["loginID"];
    $loginPassword = $_POST["loginPassword"];

    $studentLoginQuery = "SELECT * FROM student WHERE studentID = '$loginID'";
    $studentLoginResult = $connection->query($studentLoginQuery);
    $supervisorLoginQuery = "SELECT * FROM supervisor WHERE supervisorID = '$loginID'";    
    $supervisorLoginResult = $connection->query($supervisorLoginQuery);
   
    if ($studentLoginResult->num_rows > 0) {
        while($studentLoginRow = $studentLoginResult->fetch_assoc()) {
            $passFromDB = $studentLoginRow["password"];

            if ($loginPassword == $passFromDB) {
                
                $updateStudentQuery = "UPDATE student SET loggedIn = 1, lastIP = '$ip', lastLoggedIn = now() WHERE studentID = '$loginID'";
                
                if ($connection->query($updateStudentQuery) === TRUE) {
                    header("Refresh:0.01; url=../index.php");
                } else {
                    echo "Error: " . $updateStudentQuery . "<br>" . $connection->error;
                }
            } else {
                echo "Error: Incorrect details!";
                header("Refresh:2; url=../login.php");
            } 
        }
    } else if ($supervisorLoginResult->num_rows > 0) {
        while($supervisorLoginRow = $supervisorLoginResult->fetch_assoc()) {
            $passFromDB = $supervisorLoginRow["password"];

            if ($loginPassword == $passFromDB) {

                $updateSupervisorQuery = "UPDATE supervisor SET loggedIn = 1, lastIP = '$ip', lastLoggedIn = now() WHERE supervisorID = '$loginID'";
                
                if ($connection->query($updateSupervisorQuery) === TRUE) {
                    header("Refresh:0.01; url=../index.php");
                } else {
                    echo "Error: " . $updateSupervisorQuery . "<br>" . $connection->error;
                }
            } else {
                echo "Error: Incorrect details!";
                header("Refresh:2; url=../login.php");
            }
        }
    }

    $connection->close();
?>