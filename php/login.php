<?php

    $conn = mysqli_connect("localhost", "phpaccess", "dF43ERt1$", "TestWebsite");
     
    // Check connection
    if($conn === false){
        die("CONNECTION ERROR!" . mysqli_connect_error());
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    $emailAddress = $_POST["emailLogin"];
    $password = $_POST["passwordLogin"];

    $sql = "SELECT * FROM user WHERE emailAddress='$emailAddress'";
   
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                $dbpass = $row["password"];
                $userID = $row["userID"];
                if ($password == $dbpass) {
                    $sessionSQL = "UPDATE user SET loggedIn = true, ipAddress = '$ip' WHERE userID='$userID'";
                    if ($conn->query($sessionSQL) === TRUE) {
                        header("Refresh:0.5; url=../index.php");
                    }
                } else {
                    echo "Incorrect password!";
                    header("Refresh:2; url=../login.php");
                }
            }
        }
    }

    $conn->close();
?>