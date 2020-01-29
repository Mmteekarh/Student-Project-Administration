<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Database connection and title -->
    <?php include "includes/connect.php" ?>
    <title>My Selection - SPAS</title>

</head>


<body>

    <?php
        if ($loggedIn == true) {
            if ($userType == "student") {
    ?>

    <!-- Includes navigation bar -->
    <?php include "includes/nav.php" ?>

    <!-- Header containing the title and subtitle of the page -->
    <header>

        <br>
        <center><h2>My Selection</h2></center>
        <br>
        
    </header>

    <!-- Main Page Content -->
    <div class="container">

        <?php
            $query = "SELECT * FROM student WHERE studentID='$studentID'";

            if ($result = mysqli_query($connection, $query)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                        $firstChoice = $row['projectFirstChoice'];
                        $secondChoice = $row['projectSecondChoice'];
                        $thirdChoice = $row['projectThirdChoice'];
                    }
                }
            } else {
                echo "Error: " . $query . "<br>" . $connection->error;
            }

            $firstChoiceQuery = "SELECT * FROM project WHERE projectID='$firstChoice'";

            if ($result = mysqli_query($connection, $firstChoiceQuery)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                        $projectTitle = $row["projectTitle"];
                        echo "<center><p><b>First Choice:</b> <a href='projects/".$firstChoice.".php'>" . $projectTitle . "</a>";
                        echo '<form action="php/removeSelection.php" method="post" role="form">';
                        echo '<input type="hidden" name="studentID" value="'. $studentID .'">';
                        echo '<input type="hidden" name="choiceNumber" value="1">';
                        echo '<button type="submit">Remove</button></form></center><br>'; 
                    }
                } else {
                    echo "<center><b>You have not selected a first choice</b></center>";
                }
            } else {
                echo "Error: " . $firstChoiceQuery . "<br>" . $connection->error;
            }

            $secondChoiceQuery = "SELECT * FROM project WHERE projectID='$secondChoice'";

            if ($result = mysqli_query($connection, $secondChoiceQuery)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                        $projectTitle = $row["projectTitle"];
                        echo "<center><p><b>Second Choice:</b> <a href='projects/".$firstChoice.".php'>" . $projectTitle . "</a>";
                        echo '<form action="php/removeSelection.php" method="post" role="form">';
                        echo '<input type="hidden" name="studentID" value="'. $studentID .'">';
                        echo '<input type="hidden" name="choiceNumber" value="2">';
                        echo '<button type="submit">Remove</button></form></center><br>'; 
                    }
                } else {
                    echo "<center><b>You have not selected a second choice</b></center>";
                }
            } else {
                echo "Error: " . $secondChoiceQuery . "<br>" . $connection->error;
            }

            $thirdChoiceQuery = "SELECT * FROM project WHERE projectID='$thirdChoice'";

            if ($result = mysqli_query($connection, $thirdChoiceQuery)) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                        $projectTitle = $row["projectTitle"];
                        echo "<center><p><b>Third Choice:</b> <a href='projects/".$firstChoice.".php'>" . $projectTitle . "</a>";
                        echo '<form action="php/removeSelection.php" method="post" role="form">';
                        echo '<input type="hidden" name="studentID" value="'. $studentID .'">';
                        echo '<input type="hidden" name="choiceNumber" value="3">';
                        echo '<button type="submit">Remove</button></form></center><br>'; 
                    }
                } else {
                    echo "<center><b>You have not selected a third choice</b></center>";
                }
            } else {
                echo "Error: " . $thirdChoiceQuery . "<br>" . $connection->error;
            }

            $connection->close();

        ?>

        <br><br>  

    </div>
     
    <!-- Includes footer -->
    <?php include "includes/footer.php" ?>

    <?php
        
            } else if ($userType == "supervisor" or $userType == "admin") {
                header("Refresh:0.01; url=../admin/supervisor.php");

            } else {
                // Invalid user type
                header("Refresh:0.01; url=error/usertypeerror.php");
            }
        } else {
            header("Refresh:0.01; url=login.php");
        }
    ?>

</body>

</html>

