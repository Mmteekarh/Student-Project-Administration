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

    $studentLogoutQuery = "UPDATE student SET loggedIn=0 WHERE lastIP='$ip'";
    $supervisorLogoutQuery = "UPDATE supervisor SET loggedIn=0 WHERE lastIP='$ip'";
   
    
    if ($result = mysqli_query($connection, $studentLogoutQuery)) {
        header("Refresh:0.01; url=../index.php");
    } else {
        echo "Error: " . $studentLogoutQuery . "<br>" . $connection->error;
    } 

    if ($result = mysqli_query($connection, $supervisorLogoutQuery)) {
        header("Refresh:0.01; url=../index.php");
    } else {
        echo "Error: " . $supervisorLogoutQuery . "<br>" . $connection->error;
    }    

    $connection->close();
?>