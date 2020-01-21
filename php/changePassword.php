<?php
    $conn = mysqli_connect("localhost", "phpaccess", "dF43ERt1$", "TestWebsite");
     
    // Check connection
    if($conn === false){
        die("CONNECTION ERROR!" . mysqli_connect_error());
    }

	$currentPassword = $_POST['currentPassword'];
	$newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    $ip = $_SERVER['REMOTE_ADDR'];

	$sql = "SELECT * FROM user WHERE ipAddress = '$ip' AND loggedIn = true";

	if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)){
                if ($currentPassword == $row["password"]) {
                    if ($newPassword == $confirmNewPassword) {

                        $update = "UPDATE user SET password='$newPassword' WHERE ipAddress='$ip'";

                        if ($conn->query($update) === TRUE) {
                            echo "Changed password!";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
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

	$conn->close();

	header("Refresh:2; url=../account.php");

?>