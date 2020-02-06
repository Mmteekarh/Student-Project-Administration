<!-- Page contains a students' selected projects and allows them to remove them -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/connect.php" ?>
    <?php include "includes/header.php" ?>
    <?php include "includes/userscript.php" ?>

    <title>My Selection - SPAS</title>

</head>


<body>

    <!-- Checks if the user is logged in as a student -->
    <?php
        if ($loggedIn == true) {
            if ($userType == "student") {
    ?>

    <!-- Includes main navigation bar -->
    <?php include "includes/mainnav.php" ?>

    <!-- Header containing the title of the page -->
    <header>

        <br>
        <center><h2>My Selection</h2></center>
        <br>
        
    </header>

    <!-- Main page content includes list of selected projects. -->
    <div class="container">

        <?php

            // Query gets students choices using the student ID.
            $query = "SELECT * FROM student WHERE studentID = '$loggedInStudentID'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $firstChoice = $row['projectFirstChoice'];
                    $secondChoice = $row['projectSecondChoice'];
                    $thirdChoice = $row['projectThirdChoice'];
                }
            } else {
                echo "Error: No records found in the table!";
            }

            // Query to get first choice and displays a hidden form with a button to remove the choice.
            $firstChoiceQuery = "SELECT * FROM project WHERE projectID = '$firstChoice'";
            $firstChoiceResult = $connection->query($firstChoiceQuery);

            if ($firstChoiceResult->num_rows > 0) {
                while($firstChoiceRow = $firstChoiceResult->fetch_assoc()) {
                    $projectTitle = $firstChoiceRow["projectTitle"];
                    echo "<center><p><b>First Choice:</b> <a href='projects/" . $firstChoice . ".php'>" . $projectTitle . "</a>";
                    echo '<form action="php/removeSelection.php" method="post" role="form">';
                    echo '<input type="hidden" name="studentID" value="'. $loggedInStudentID .'">';
                    echo '<input type="hidden" name="choiceNumber" value="1">';
                    echo '<button type="submit">Remove</button></form></center><br>'; 
                }
            } else {
                echo "<center><b>You have not selected a first choice</b></center>";
            }

            // Query to get second choice and displays a hidden form with a button to remove the choice.
            $secondChoiceQuery = "SELECT * FROM project WHERE projectID = '$secondChoice'";
            $secondChoiceResult = $connection->query($secondChoiceQuery);

            if ($secondChoiceResult->num_rows > 0) {
                while($secondChoiceRow = $secondChoiceResult->fetch_assoc()) {
                    $projectTitle = $secondChoiceRow["projectTitle"];
                    echo "<center><p><b>Second Choice:</b> <a href='projects/" . $secondChoice . ".php'>" . $projectTitle . "</a>";
                    echo '<form action="php/removeSelection.php" method="post" role="form">';
                    echo '<input type="hidden" name="studentID" value="'. $loggedInStudentID .'">';
                    echo '<input type="hidden" name="choiceNumber" value="2">';
                    echo '<button type="submit">Remove</button></form></center><br>'; 
                }
            } else {
                echo "<center><b>You have not selected a second choice</b></center>";
            }

            // Query to get third choice and displays a hidden form with a button to remove the choice.
            $thirdChoiceQuery = "SELECT * FROM project WHERE projectID = '$thirdChoice'";
            $thirdChoiceResult = $connection->query($thirdChoiceQuery);

            if ($thirdChoiceResult->num_rows > 0) {
                while($thirdChoiceRow = $thirdChoiceResult->fetch_assoc()) {
                    $projectTitle = $thirdChoiceRow["projectTitle"];
                    echo "<center><p><b>Third Choice:</b> <a href='projects/" . $thirdChoice . ".php'>" . $projectTitle . "</a>";
                    echo '<form action="php/removeSelection.php" method="post" role="form">';
                    echo '<input type="hidden" name="studentID" value="'. $loggedInStudentID .'">';
                    echo '<input type="hidden" name="choiceNumber" value="3">';
                    echo '<button type="submit">Remove</button></form></center><br>'; 
                }
            } else {
                echo "<center><b>You have not selected a third choice</b></center>";
            }
            
            // Closes connection.
            $connection->close();

        ?>

        <br>
        <br>  

    </div>
     
    <!-- Includes footer -->
    <?php include "includes/footer.php" ?>

    <?php
            // If user is supervisor, redirect them to supervisor page.
            } else if ($userType == "supervisor" or $userType == "admin") {
                header("Refresh:0.01; url=../admin/supervisor.php");

            } else {
                // Invalid user type, redirect to error page.
                header("Refresh:0.01; url=error/usertypeerror.php");
            }
        } else {
            header("Refresh:0.01; url=login.php");
        }
    ?>

</body>

</html>