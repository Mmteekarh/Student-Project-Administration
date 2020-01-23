<?php

  // Contains the navigation bar for the main part of the site.

  // Includes connection to the database.
  include 'connect.php';

echo '
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">

            <a class="navbar-brand" href="../index.php">Student Project Administration System (SPAS)</a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">

                	<li class="nav-item">
                        <a class="nav-link" href="../index.php">Project List</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../selection.php">My Selection</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../account.php">Account</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../admin/admin.php">Admin</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    ';

?>