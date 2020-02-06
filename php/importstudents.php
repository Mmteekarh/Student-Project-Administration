<!-- Script used to insert students via a CSV file -->
<?php

    include "../includes/vars.php";
    include "../includes/connect.php";

    // Check if a file has been posted and get its name.
    if(isset($_POST["Import"])) {
        $filename = $_FILES["file"]["tmp_name"]; 

        // Check if the file has any data and opens it.
        if($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");

            // Loops through each line of the file using the comma as a separator, gets each field and stores in a variable.
            while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {
                $studentID = $data[0];
                $firstName = $data[1];
                $middleInitial = $data[2];
                $lastName = $data[3];
                $yearOfStudy = $data[4];
                $plp = $data[5];
                $password = $data[6];
                $courseID = $data[7];

                $query = "INSERT INTO student (studentID, firstName, middleInitial, lastName, yearOfStudy, plp, password, courseID, dateCreated, lastUpdated) VALUES ('$studentID', '$firstName', '$middleInitial', '$lastName', '$yearOfStudy', '$plp', '$password', '$courseID', now(), now())";

                if ($connection->query($query) === TRUE) {
                    echo "The student file was successfully imported.";
                } else {
                    echo "Error: " . $query . "<br>" . $connection->error;
                }

            }
        }
    }

	header("Refresh:2; url=../admin/systemmanagement/studentlist.php");

    $connection->close();

?>

