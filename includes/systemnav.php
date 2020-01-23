<?php

  // Contains the navigation bar for the main part of the site.

  // Includes connection to the database.
  include 'connect.php';

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
                    <a class="nav-link" href="../../admin/systemmanagement.php">System Management</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../../admin/addsupervisor.php">Add Supervisor</a>
                </li>

            </ul>

        </div>

    </nav>
    ';

?>