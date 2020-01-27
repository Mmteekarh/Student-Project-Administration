<?php

    // Gets the IP of the user viewing the website and the current date/time.
    $ip = $_SERVER['REMOTE_ADDR'];
    $currentDate = date("Y/m/d H:i:sa");

    // Attempts to make a connection to the database with given fields.
    $connection = mysqli_connect("localhost", "phpaccess", "t5eXXf0@s3", "SPAS");
           
    // If the connection failed, log an error and print a user-friendly message.
    if($connection === false){
        echo "ERROR: at " . $currentDate . " by " . $ip . " Caused by: " . mysqli_connect_error();
        die("Oh no! There was a connection error, please contact an administrator.");
    }

    $loginID = $_POST["loginID"];
    $loginPassword = $_POST["loginPassword"];

    $studentLoginQuery = "SELECT * FROM student WHERE studentID='$loginID'";
    $supervisorLoginQuery = "SELECT * FROM supervisor WHERE supervisorID='$loginID'";
   
    if ($result = mysqli_query($connection, $studentLoginQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $dbpass = $row["password"];
                if ($loginPassword == $dbpass) {
                    $query = "UPDATE student SET loggedIn = 1, lastIP = '$ip' WHERE studentID='$loginID'";
                        if ($result = mysqli_query($connection, $query)) {
                            header("Refresh:0.01; url=../index.php");
                        } else {
                            echo "Error: " . $query . "<br>" . $connection->error;
                        }
                    } else {
                        echo "Error: Incorrect details!";
                        header("Refresh:2; url=../login.php");
                    }
                }   
        }
    } else {
        echo "ERROR: MySQL query result error";
    }


    if ($result = mysqli_query($connection, $supervisorLoginQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $dbpass = $row["password"];
                if ($loginPassword == $dbpass) {
                    $query = "UPDATE supervisor SET loggedIn = 1, lastIP = '$ip' WHERE supervisorID='$loginID'";
                        if ($result = mysqli_query($connection, $query)) {
                            header("Refresh:0.01; url=../index.php");
                        } else {
                            echo "Error: " . $query . "<br>" . $connection->error;
                        }
                } else {
                    echo "Error: Incorrect details!";
                    header("Refresh:2; url=../login.php");
                }
            }
        } 
    } else {
        echo "ERROR: MySQL query result error";
    }

    $connection->close();
?>