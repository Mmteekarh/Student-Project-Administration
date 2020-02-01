<?php

  // Contains the navigation bar for the main part of the site.

  // Includes connection to the database.
  include 'connect.php';

echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">

            <a class="navbar-brand" href="../../admin/admin.php">Admin</a>

            <ul class="nav navbar-nav">

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

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Students<span class="caret"></span></a>                    
                    <ul class="dropdown-menu">
                        <li><a href="../../admin/systemmanagement/studentlist.php">Student List</a></li>
                        <li><a href="../../admin/systemmanagement/addstudent.php">Add Student</a></li>
                        <li><a href="../../admin/systemmanagement/importstudents.php">Import Students</a></li>
                        <li><a href="../../admin/systemmanagement/editstudent.php">Edit Student</a></li>
                        <li><a href="../../admin/systemmanagement/removestudent.php">Remove Student</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Supervisors<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../../admin/systemmanagement/supervisorlist.php">Supervisor List</a></li>
                        <li><a href="../../admin/systemmanagement/addsupervisor.php">Add Supervisor</a></li>
                        <li><a href="../../admin/systemmanagement/editsupervisor.php">Edit Supervisor</a></li>
                        <li><a href="../../admin/systemmanagement/removesupervisor.php">Remove Supervisor</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Courses<span class="caret"></span></a>                    
                    <ul class="dropdown-menu">
                        <li><a href="../../admin/systemmanagement/addcourse.php">Add Course</a></li>
                        <li><a href="../../admin/systemmanagement/editcourse.php">Edit Course</a></li>
                        <li><a href="../../admin/systemmanagement/removecourse.php">Remove Course</a></li>
                    </ul>
                </li>

            </ul>

        </div>

    </nav>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js"></script>

    ';

?>