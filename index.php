<!-- Main page of the site, access is available to logged out users, contains project list. -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Includes required scripts. -->
    <?php include "includes/header.php" ?>
    <?php include "includes/connect.php" ?>
    <?php include "includes/userscript.php" ?>

    <title>Project List - SPAS</title>

</head>


<body>

    <!-- Includes main navigation bar -->
    <?php include "includes/mainnav.php" ?>

    <!-- Header containing the title and subtitle of the page -->
    <header>

        <br>
        <center><h2>List of Projects</h2></center>
        <br>
        
    </header>

    <!-- Main page content such as project list and login button contained in a container. -->
    <div class="container">

        <!-- Row includes course selector and login/logout button -->
        <div class="row">

            <!-- Uses first 11 bootrap columns to display the dropdown menu to select a coure. -->
            <div class="col-md-11">

                <!-- Form used to select a course and post the result to the project list -->
                <form method="POST">
                    <select name="courseID">
                        <!-- Adds an option to select all courses -->
                  	    <option value="0">All Courses</option>
                        
                        <?php

                            // Query to select all courses.
                            $query = "SELECT * FROM course";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                // Loops through all courses available.
                                while($row = $result->fetch_assoc()) {
                                    // Gets course name and course ID and uses them to form a new option.
                                    $courseName = $row['courseName'];
                                    $courseID = $row['courseID'];
                                    echo '<option value="'.$courseID.'">' . $courseName . '</option>';
                                }
                            } else {
                                echo "Error: No results found in the table!";
                            }
                        ?>

                    </select>

                    <button type="submit" name="submit">Submit</button>

                </form>

            </div>

            <!-- The last column is used to display the login/logout button -->
            <div class="col-md-1">

                <?php
                    // If the user is logged in, display the logout button.
                    if ($loggedIn == true) {

                        if ($userType == "student" or $userType == "supervisor" or $userType == "admin") {
                            echo '<form action="php/logout.php">';
                            echo '<button type="submit" class="btn btn-danger">Logout</button>';
                            echo '</form>';
                        } else {
                            // Invalid user type, redirects to error page.
                            header("Refresh:0.01; url=error/invalidusererror.php");
                        }

                    } else {
                            // Display the login button if the user is logged out.
                            echo '<form action="login.php">';
                            echo '<button type="submit" class="btn btn-primary">Login</button>';
                            echo '</form>';
                    }
                ?>

            </div>

        </div>

        <br>

        <!-- Next row contains list of projects -->
        <div class="row">

            <!-- Creates a table with headings, used to display the projects clearly. -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Project Title</th>
                        <th scope="col">Project Brief</th>
                        <th scope="col">Supervisor</th>
                    </tr>
                </thead>
                
                <tbody>

                    <?php

                        // Checks if the form was submitted and gets the course ID of the requested course.
    	                if (isset($_POST["submit"])) {
    						$courseID = $_POST["courseID"];

    					} else {

                            // If the form was not submitted, display all projects.
    						$query = "SELECT * FROM project";
                            $result = $connection->query($query);

    	                    if ($result->num_rows > 0) {
    	                        while($row = $result->fetch_assoc()) {

                                    // Gets details from database table.
                                    $projectTitle = $row['projectTitle'];
    	                            $projectBrief = $row['projectBrief'];
    	                            $projectID = $row['projectID'];
    	                            $projectSupervisor = getSupervisorName($connection, $row['supervisorID']);

                                    // Create new row of table with new information.
    	                            echo '<tr>';
    	                            echo '<th scope="row"><a href="../projects/' . $projectID . '.php">' . $projectTitle . '</a></th>';
    	                            echo '<td>' . substr($projectBrief, 0, 100) . '...</td>';
    	                            echo '<td>' . $projectSupervisor . '</td>';
    	                            echo '</tr>';
    	                        }

    	                    } else {
                                echo "Error: No records found in the table!";    	                    
                            }		
    					}

                        // Checks if course ID is 0 (all courses have been selected).
    					if ($courseID == 0) {

                            // Query to display all projects.
    						$query = "SELECT * FROM project";
                            $result = $connection->query($query);

    	                    if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {

                                    // Gets details from database table.
                                    $projectTitle = $row['projectTitle'];
                                    $projectBrief = $row['projectBrief'];
                                    $projectID = $row['projectID'];
                                    $projectSupervisor = getSupervisorName($connection, $row['supervisorID']);

                                    // Create new row of table with new information.
                                    echo '<tr>';
                                    echo '<th scope="row"><a href="../projects/' . $projectID . '.php">' . $projectTitle . '</a></th>';
                                    echo '<td>' . substr($projectBrief, 0, 100) . '...</td>';
                                    echo '<td>' . $projectSupervisor . '</td>';
                                    echo '</tr>';
                                }

                            } else {
                                echo "Error: No records found in the table!";                           
                            }       		

                        // If the user has selected a specific course, find it in the projectCourse table.
    					} else {

                            // Query to join projectCourse and project tables and get the details from each.
    						$query = "SELECT * FROM projectCourse INNER JOIN project ON projectCourse.projectID = project.projectID WHERE projectCourse.courseID = '$courseID'";
                            $result = $connection->query($query);

    	                    if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {

                                    // Gets details from database table.
                                    $projectTitle = $row['projectTitle'];
                                    $projectBrief = $row['projectBrief'];
                                    $projectID = $row['projectID'];
                                    $projectSupervisor = getSupervisorName($connection, $row['supervisorID']);

                                    // Create new row of table with new information.
                                    echo '<tr>';
                                    echo '<th scope="row"><a href="../projects/' . $projectID . '.php">' . $projectTitle . '</a></th>';
                                    echo '<td>' . substr($projectBrief, 0, 100) . '...</td>';
                                    echo '<td>' . $projectSupervisor . '</td>';
                                    echo '</tr>';
                                }

                            } else {
                                echo "Error: No records found in the table!";                           
                            }       
    					}

                        // Function uses the supervisor ID to get the supervisor name from the supervisor table.
                        function getSupervisorName($connection, $supervisorID) {

                            // Queries the database to get the supervisor field.
                            $query = "SELECT * FROM supervisor WHERE supervisorID = '$supervisorID'";
                            $result = $connection->query($query);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $supervisorTitle = $row['supervisorTitle'];
                                    $supervisorFirstName = $row['firstName'];
                                    $supervisorLastName = $row['lastName'];
                                    $supervisorName = $supervisorTitle . " " . $supervisorFirstName . " " . $supervisorLastName;
                                }
                            
                            } else {
                                echo "Error: No records found in the table!";
                            }

                            return $supervisorName;
                        }

                        // Closes connection
                        $connection->close();

                    ?>

                </tbody>
            </table>

            <br>
            <br>
            <br>

        </div>
    </div>
     
    <!-- Includes footer -->
    <?php include "includes/footer.php" ?>

</body>

</html>