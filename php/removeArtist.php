<?php
    $conn = mysqli_connect("localhost", "phpaccess", "dF43ERt1$", "TestWebsite");
     
    // Check connection
    if($conn === false){
        die("CONNECTION ERROR!" . mysqli_connect_error());
    }

    $artistID = $_POST['artistID'];

    $sql = "DELETE FROM artists WHERE artistID='$artistID'";

    if ($conn->query($sql) === TRUE) {
        echo "Success!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

	$conn->close();

	header("Refresh:2; url=../admin/remove.php");

?>