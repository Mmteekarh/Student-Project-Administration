<!-- Script generates a report with project information relating to the supervisor -->
<?php

    include "../includes/connect.php";

    $supervisorID = $_POST["supervisorID"];
   
    $supervisorQuery = "SELECT student.firstName, student.middleInitial, student.lastName, project.projectTitle 
                        FROM supervisor INNER JOIN project ON supervisor.supervisorID = project.supervisorID 
                        INNER JOIN student ON project.projectID = student.projectID WHERE supervisor.supervisorID = '$supervisorID'";
    $supervisorResult = $connection->query($supervisorQuery);

    if ($supervisorResult->num_rows > 0) {

        // Sets the delimiter to comma and creates the file name.
        $delimiter = ",";
        $filename = "supervisor_" . $supervisorID . ".csv";
    
        // Opens a temp file pointer
        $file = fopen('php://memory', 'w');
        
        // Sets column headers and adds to file.
        $fields = array('firstName', 'middleInitial', 'lastName', 'projectTitle');
        fputcsv($file, $fields, $delimiter);

        while($supervisorRow = $supervisorResult->fetch_assoc()) {
            $supervisorTitle = $supervisorRow["supervisorTitle"];
            $firstName = $supervisorRow["firstName"];
            $lastName = $supervisorRow["lastName"];
            $middleInitial = $supervisorRow["middleInitial"];
            $projectTitle = $supervisorRow["projectTitle"];

            // Creates a new array with the data and puts data on a new line in the file.
            $row = array($firstName, $middleInitial, $lastName, $projectTitle);
            fputcsv($file, $row, $delimiter);

        }

        // Sets the position to the start of the file.
        fseek($file, 0);
    
        // Make the browser download the file.
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        // Reads current position in the file then outputs the data.
        fpassthru($file);
    }

    $connection->close();
?>