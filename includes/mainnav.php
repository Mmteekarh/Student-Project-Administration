<!-- Includes the main navigation bar for the website. -->
<?php

    // Includes user script for getting user types.
    include 'userscript.php';


    echo '
            <!-- Required JQuery scripts for running the drop down on the collapse button -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

            <!-- Class attributes ensure navbar stays fixed at the top and gives it a darker background. -->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <div class="container">

                    <!-- Bootstrap brand for the site, links back to project list page. -->
                    <a class="navbar-brand" href="../index.php">Student Project Administration System (SPAS)</a>

                    <!-- Creates a toggle button which activates when the page gets small (runs on mobile devices) -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsableNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="collapsableNavbar">
                        <!-- List of pages in the navigation -->
                        <ul class="nav navbar-nav ml-auto">

                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Project List</a>
                            </li>
        ';

    // Checks if the user is logged in and displays the account tab.
    if ($loggedIn == true) {
         echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../account.php">Account</a>
                            </li>
            ';

        // Checks if user is a student and displays the selection tab.
        if ($userType == "student") {

            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../selection.php">My Selection</a>
                            </li>
                ';

        // Checks if user is an admin or supervisor and displays the admin tab.
        } else if ($userType == "admin" or $userType == "supervisor") {

            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/admin.php">Admin</a>
                            </li>
                ';
        }
    }

    echo '
                    </div>
                    </ul>

                </div>

            </nav>
    ';

?>