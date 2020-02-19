<!-- Includes the main navigation bar for the website. -->
<?php

    // Includes user script for getting user types.
    include 'userscript.php';

    echo '
            <!-- Class attributes ensure navbar stays fixed at the top and gives it a darker background. -->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <div class="container">

                    <!-- Bootstrap brand for the site, links back to project list page. -->
                    <a class="navbar-brand" href="../index.php">Student Project Administration System (SPAS)</a>

                    <!-- List of pages in the navigation -->
                    <ul class="nav navbar-nav">

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
                    </ul>

                </div>

            </nav>
    ';

?>