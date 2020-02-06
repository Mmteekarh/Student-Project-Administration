<!-- Script changes a users password -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";
    include "../includes/userscript.php";

	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    $userType = $_POST['userType'];

    if ($userType == "student") {

        $studentQuery = "SELECT * FROM student WHERE lastIP = '$ip' AND loggedIn = 1";
    	$studentResult = $connection->query($studentQuery);

        if ($studentResult->num_rows > 0) {
            while($studentRow = $studentResult->fetch_assoc()) {

                if ($currentPassword == $studentRow["password"]) {
                    if ($newPassword == $confirmNewPassword) {

                        $studentUpdateQuery = "UPDATE student SET password = '$newPassword' WHERE lastIP = '$ip'";

                        if ($connection->query($studentUpdateQuery) === TRUE) {
                            echo "Changed password!";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }

                    } else {
                        echo "Passwords do not match!";
                    }
                } else {
                    echo "Incorrect password!";
                }
            }
        }

    } else if ($userType == "supervisor" or $userType == "admin") {

        $supervisorQuery = "SELECT * FROM supervisor WHERE lastIP = '$ip' AND loggedIn = 1";
        $supervisorResult = $connection->query($supervisorQuery);

        if ($supervisorResult->num_rows > 0) {
            while($supervisorRow = $supervisorResult->fetch_assoc()) {

                if ($currentPassword == $supervisorRow["password"]) {
                    if ($newPassword == $confirmNewPassword) {

                        $supervisorUpdateQuery = "UPDATE supervisor SET password = '$newPassword' WHERE lastIP = '$ip'";

                        if ($connection->query($supervisorUpdateQuery) === TRUE) {
                            echo "Changed password!";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }

                    } else {
                        echo "Passwords do not match!";
                    }
                } else {
                    echo "Incorrect password!";
                }
            }
        }

    } else {
        // Invalid user type
        header("Refresh:0.01; url=error/usertypeerror.php");
    }

	$connection->close();

	header("Refresh:2; url=../account.php");

?>