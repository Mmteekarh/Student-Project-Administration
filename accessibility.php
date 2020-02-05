<!-- Page includes ability to change contrast of the page along with accessibility information. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/header.php" ?>

    <title>Accessibility</title>

</head>


<body>

    <!-- Includes main navigation bar -->
    <?php include "includes/mainnav.php" ?>

    <!-- Header containing the title of the page -->
    <header>

        <br>
        <center><h2>Change Contrast</h2></center>
        <br>
        
    </header>

    <!-- Main page content includes row to change contrast and information about accessibility -->
    <div class="container">

        <div class="row">

            <p>The contrast of the website can be change to a darker theme. This will help users who have problems with vision.</p>

        </div>

        <br>
        <br>

        <!-- Buttons to switch between high and normal contrast -->
        <div class="row">

            <div class="col-md-6 text-center"> 
                <!-- Form posts to php script to change contrast -->
                <form name="highContrast" action="php/highContrast.php" method="POST" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-success">High Contrast</button>
                </form>
            </div>

            <br>

            <div class="col-md-6 text-center"> 
                <!-- Form posts to php script to change contrast -->
                <form name="normalContrast" action="php/normalContrast.php" method="POST" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-success">Normal Contrast</button>
                </form>
            </div>

        </div>

        <br>
        <br> 

        <!-- Row shows information about accessibility on the website -->
        <div class="row">

            <center>
                <h4>Accessibility Information</h4>
                <p>If you require extra accessibility features or any help with the website, please contact a system administrator. This website is designed to be easy to follow and as simple as possible.</p>
            </center>

        </div>

    </div>
     
    <!-- Includes footer -->
    <?php include "includes/footer.php" ?>

</body>

</html>