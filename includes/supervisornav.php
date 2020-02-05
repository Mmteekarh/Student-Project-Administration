<!-- Includes navigation for the supervisor area of the admin panel. -->
<?php

echo '
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">

                <a class="navbar-brand" href="../../admin/admin.php">Admin</a>

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Back To Site</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/admin.php">Admin Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/supervisor.php">Supervisor Tools</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/supervisor/addproject.php">Add Project</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/supervisor/editproject.php">Edit Project</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../admin/supervisor/removeproject.php">Remove Project</a>
                    </li>

                </ul>

            </div>

        </nav>
    ';

?>