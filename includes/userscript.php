<!-- Script for checking if a user is logged in and getting the logged in users' data -->
<?php

    // Includes connection to the database.
	include 'connect.php';

    // Set variables with default values.
    $loggedIn = false;
    $userType = "";
    $loggedInStudentID = 0;
    $loggedInSupervisorID = 0;

    // Defines and runs queries for checking student and supervisor tables.
    $studentQuery = "SELECT * FROM student WHERE lastIP = '$ip' AND loggedIn = 1";
    $studentResult = $connection->query($studentQuery);

    $supervisorQuery = "SELECT * FROM supervisor WHERE lastIP = '$ip' AND loggedIn = 1";
    $supervisorResult = $connection->query($supervisorQuery);

    // Gets rows from student table and if the rows exist, set the logged in variables.
    if ($studentResult->num_rows > 0) {
        while($row = $studentResult->fetch_assoc()) {
            $loggedIn = true;
            $userType = "student";
            $loggedInStudentID = $row["studentID"];
        }
    }

    // Gets rows from supervisor table and if the rows exist, set the logged in variables.
    if ($supervisorResult->num_rows > 0) {
        while($row = $supervisorResult->fetch_assoc()) {
            $loggedIn = true;
            $userType = "supervisor";
            $loggedInSupervisorID = $row["supervisorID"];

            // Check if the supervisor is also an admin and if so, set the user type accordingly.
            if ($row["admin"] == 1) {
                $userType = "admin";
            }
        }
    }

?>