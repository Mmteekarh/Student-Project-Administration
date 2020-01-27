<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Database connection and title -->
    <?php include "includes/connect.php" ?>
    <title>Login - SPAS</title>

</head>


<body>

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

        <div class="card">
            <div class="card-body">

                <form class="form-signin" name="loginForm" action="php/login.php" method="post" enctype="multipart/form-data">

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
    
    <?php
        $connection->close();
    ?>


</body>

</html>

