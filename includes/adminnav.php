<!-- Includes the navigation bar for the main admin panel. -->
<?php

    // Includes user script for getting user types.
    include 'userscript.php';

    echo '
            <!-- Class attributes ensure navbar stays fixed at the top and gives it a darker background. -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container">

                    <!-- Bootstrap brand for the site, links back to main admin page. -->
                    <a class="navbar-brand" href="../admin/admin.php">Admin</a>

                    <!-- List of pages in the navigation -->
                    <ul class="navbar-nav">

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
                    </ul>

                </div>

            </nav>
        ';

?>