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

        

    </div>
     
    <!-- Includes footer -->
    <?php include "includes/footer.php" ?>

    <?php
        
        } else if ($userType == "supervisor") {
            header("Refresh:0.01; url=../admin/supervisor.php");

            } else {
                echo "Error: Invalid user type, please contact an administrator.";
            }
        } else {
            header("Refresh:0.01; url=login.php");
        }
    ?>

</body>

</html>

