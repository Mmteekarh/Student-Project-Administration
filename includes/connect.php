<?php

	// Gets the IP of the user viewing the website and the current date/time.
    $ip = $_SERVER['REMOTE_ADDR'];
    $currentDate = date("Y/m/d H:i:sa");

    // Displays the head contents of each page, loading stylesheets and setting meta variables.
	echo '
		<meta charset="utf-8">
	  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  	<meta name="description" content="Student Project Administration System (SPAS)">
	  	<meta name="author" content="Jake Taylor">

	  	<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

 		<link href="../../css/modern-business.css" rel="stylesheet">
	  	';

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

?>