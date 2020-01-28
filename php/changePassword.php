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

    $loggedIn = false;
        $userType = "none";
        $studentID;
        $supervisorID;

        $studentQuery = "SELECT * FROM student where lastIP='$ip' AND loggedIn=1";
        $supervisorQuery = "SELECT * FROM supervisor where lastIP='$ip' AND loggedIn=1";

        if ($result = mysqli_query($connection, $studentQuery)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)){
                    $loggedIn = true;
                    $userType = "student";
                    $studentID = $row["studentID"];
                }
            }
        }

        if ($result = mysqli_query($connection, $supervisorQuery)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)){
                    $loggedIn = true;
                    $userType = "supervisor";
                    $supervisorID = $row["supervisorID"];
                    if ($row["admin"] == 1) {
                        $userType = "admin";
                    }
                }
            }
        }

	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

	$supervisorQuery = "SELECT * FROM supervisor WHERE lastIP = '$ip' AND loggedIn = 1";
    $studentQuery = "SELECT * FROM student WHERE lastIP = '$ip' AND loggedIn = 1";

	if ($result = mysqli_query($connection, $studentQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                if ($currentPassword == $row["password"]) {
                    if ($newPassword == $confirmNewPassword) {

                        $update = "UPDATE student SET password='$newPassword' WHERE lastIP='$ip'";

                        if ($connection->query($update) === TRUE) {
                            echo "Changed password!";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }
                    } else{
                        echo "Passwords do not match!";
                    }
                } else {
                    echo "Incorrect password!";
                }
            }
        }
    }

    if ($result = mysqli_query($connection, $supervisorQuery)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                if ($currentPassword == $row["password"]) {
                    if ($newPassword == $confirmNewPassword) {

                        $update = "UPDATE supervisor SET password='$newPassword' WHERE lastIP='$ip'";

                        if ($conn->query($update) === TRUE) {
                            echo "Changed password!";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }
                    } else{
                        echo "Passwords do not match!";
                    }
                } else {
                    echo "Incorrect password!";
                }
            }
        }
    }

	$connection->close();

	header("Refresh:2; url=../account.php");

?>