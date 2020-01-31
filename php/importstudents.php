<?php

    $ip = $_SERVER['REMOTE_ADDR'];
    $currentDate = date("Y/m/d H:i:sa");

    // Attempts to make a connection to the database with given fields.
    $connection = mysqli_connect("localhost", "phpaccess", "t5eXXf0@s3", "SPAS");
           
    // If the connection failed, log an error and print a user-friendly message.
    if($connection === false){
        echo "ERROR: at " . $currentDate . " by " . $ip . " Caused by: " . mysqli_connect_error();
        die("Oh no! There was a connection error, please contact an administrator.");
    }

    if(isset($_POST["Import"])) {
        $filename = $_FILES["file"]["tmp_name"];    
        if($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {
                $studentID = $data[0];
                $firstName = $data[1];
                $middleInitial = $data[2];
                $lastName = $data[3];
                $yearOfStudy = $data[4];
                $plp = $data[5];
                $password = $data[6];

                $query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password) VALUES ('$studentID', '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', '$plp', '$password')";

            if ($result = mysqli_query($connection, $query)) {
                echo "The student file was successfully imported.";
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }

            }
        }
    }

	header("Refresh:2; url=../admin/systemmanagement/importstudents.php");

    $connection->close();

?>