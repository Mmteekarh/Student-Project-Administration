<!-- Includes the navigation for the system administrator section of the admin panel. -->
<?php

echo '

        <!-- Required JQuery scripts for running the drop down on the collapse button -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">

                <a class="navbar-brand" href="../../admin/admin.php">Admin</a>

                <!-- Creates a toggle button which activates when the page gets small (runs on mobile devices) -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsableNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="collapsableNavbar">

                    <ul class="nav navbar-nav ml-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php">Back To Site</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/admin.php">Admin Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/systemmanagement.php">System Management</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/systemmanagement/deadlines.php">Deadlines</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/systemmanagement/studentlist.php">Students</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/systemmanagement/supervisorlist.php">Supervisor</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../../admin/systemmanagement/courselist.php">Courses</a>
                        </li>
         
                    </ul>

                </div>

            </div>

        </nav>

    ';

?>