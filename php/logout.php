<!-- Script logs out a user -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    $studentLogoutQuery = "UPDATE student SET loggedIn = 0 WHERE lastIP = '$ip'";
    $supervisorLogoutQuery = "UPDATE supervisor SET loggedIn = 0 WHERE lastIP = '$ip'";
   
    
    if ($connection->query($studentLogoutQuery) === TRUE) {
        header("Refresh:0.01; url=../index.php");
    } else {
        header("Refresh:0.01; url=../error/logouterror.php");    
    } 

    if ($connection->query($supervisorLogoutQuery) === TRUE) {
        header("Refresh:0.01; url=../index.php");
    } else {
        header("Refresh:0.01; url=../error/logouterror.php");
    }    

    $connection->close();
?>