<!-- Script generates a report with allocation information after the projects have been allocated -->
<?php

    include "../includes/connect.php";
   
    $query = "SELECT student.studentID, student.firstName AS studentFirstName, student.lastName AS studentLastName, project.projectTitle, student.projectID, 
                        student.projectFirstChoice, student.projectSecondChoice, student.projectThirdChoice, supervisor.supervisorTitle, 
                        supervisor.firstName AS supervisorFirstName, supervisor.lastName AS supervisorLastName, student.secondMarker FROM student 
                        INNER JOIN project ON student.projectID = project.projectID 
                        INNER JOIN supervisor ON project.supervisorID = supervisor.supervisorID";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {

        // Sets the delimiter to comma and creates the file name.
        $delimiter = ",";
        $filename = "allocation_report.csv";
    
        // Opens a temp file pointer
        $file = fopen('php://memory', 'w');
        
        // Sets column headers and adds to file.
        $fields = array('ID', 'First Name', 'Last Name', 'Assigned Title', 'Assigned Project', 'First Choice', 'Second Choice', 'Third Choice', 'Supervisor Name', 'Second Marker');
        fputcsv($file, $fields, $delimiter);

        while($row = $result->fetch_assoc()) {
            $studentID = $row["studentID"];
            $studentFirstName = $row["studentFirstName"];
            $studentLastName = $row["studentLastName"];
            $projectTitle = $row["projectTitle"];
            $projectID = $row["projectID"];
            $projectFirstChoice = $row["projectFirstChoice"];
            $projectSecondChoice = $row["projectSecondChoice"];
            $projectThirdChoice = $row["projectThirdChoice"];
            $supervisorTitle = $row["supervisorTitle"];
            $supervisorFirstName = $row["supervisorFirstName"];
            $supervisorLastName = $row["supervisorLastName"];
            $secondMarker = $row["secondMarker"];

            $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;

            // Creates a new array with the data and puts data on a new line in the file.
            $row = array($studentID, $studentFirstName, $studentLastName, $projectTitle, $projectID, $projectFirstChoice, $projectSecondChoice, $projectThirdChoice, $supervisorName, $secondMarker);
            fputcsv($file, $row, $delimiter);

        }

        // Sets the position to the start of the file.
        fseek($file, 0);
    
        // Make the browser download the file.
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        // Reads current position in the file then outputs the data.
        fpassthru($file);

        fclose($file);

        header("Refresh:0.5; url=../admin/systemmanagement.php");

    }

    $connection->close();
?>