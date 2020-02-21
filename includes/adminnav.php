<!-- Includes the navigation bar for the main admin panel. -->
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

                    <!-- Bootstrap brand for the site, links back to main admin page. -->
                    <a class="navbar-brand" href="../admin/admin.php">Admin</a>

                    <!-- Creates a toggle button which activates when the page gets small (runs on mobile devices) -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsableNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="collapsableNavbar">

                        <!-- List of pages in the navigation -->
                        <ul class="nav navbar-nav ml-auto">

                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Back To Site</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="../admin/supervisor.php">Supervisor Tools</a>
                            </li>

        ';

    // Checks if the user is an admin and if so, displays the system management tab.
    if ($userType == "admin") {

        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/systemmanagement.php">System Management</a>
                            </li>
            ';
    }

    echo '
                    </div>
                    </ul>

                </div>

            </nav>
        ';

?>