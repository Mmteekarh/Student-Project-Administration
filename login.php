<!-- Page with login form -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/connect.php" ?>
    <?php include "includes/header.php" ?>
    <?php include "includes/userscript.php" ?>

    <title>Login - SPAS</title>

</head>

<body>

    <!-- Checks if user is logged in already, if so, redirect them to home page -->
    <?php
        if ($loggedIn == true) {
            header("Refresh:0.01; url=index.php");
        }
    ?>

    <header>

        <br>
        <center><h2>Login</h2></center>
        <br>
        
    </header>

    <div class="container">

        <!-- Login form contained inside a card to give it a cleaner look. -->
        <div class="card">
            <div class="card-body">

                <!-- Login form contains ID and password which is posted to the login script in the php folder. -->
                <form class="form-signin" name="loginForm" action="php/login.php" method="POST" enctype="multipart/form-data">

                    <div class="form-label-group">
                        <center><label>Student / Supervisor ID</label></center>
                        <input type="text" class="form-control" name="loginID" placeholder="Student or Supervisor ID" required>
                    </div>

                    <div class="form-label-group">
                        <center><label>Password</label></center>
                        <input type="password" class="form-control" name="loginPassword" placeholder="Password" required>
                    </div>

                    <br>

                    <center><button type="submit" class="btn btn-lg btn-primary">Login</button></center>

                </form>

            </div>
        </div>
        
    </div>

</body>

</html>

