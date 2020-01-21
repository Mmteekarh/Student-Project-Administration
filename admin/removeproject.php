<!DOCTYPE html>
<html lang="en">

<head>

  <?php

	  $conn = mysqli_connect("localhost", "phpaccess", "dF43ERt1$", "TestWebsite");
	         
	  if($conn === false){
	    die("CONNECTION ERROR!" . mysqli_connect_error());
	  }

  ?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Website to store music and artist data.">
  <meta name="author" content="Jake Taylor">

  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="../css/modern-business.css" rel="stylesheet">

  <title>Remove Data - Admin - Music Browser</title>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="admin.php">Admin</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Main Site</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Add</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="remove.php">Remove</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <h1 class="mt-4 mb-3">Remove
      <small>Artist / Label / Album / Track</small>
    </h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="admin.php">Admin</a>
      </li>
      <li class="breadcrumb-item active">Remove Data</li>
    </ol>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Artist</h3>

        <?php
          $sql = "SELECT * FROM artists";

          if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {
                  $artistName = $row["artistName"];
                  $artistID = $row["artistID"];
                  echo $artistName;
                  echo "<br>";
                  echo '<form action="../php/removeArtist.php" method="post" role="form">';
                  echo '<input type="hidden" name="artistID" value="'. $artistID .'">';
                  echo '<button type="submit">Remove</button></form>'; 
                  echo "<br>";
              }
            }
          }
        ?>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Label</h3>

        <?php
          $sql1 = "SELECT * FROM labels";

          if ($result1 = mysqli_query($conn, $sql1)) {
            if (mysqli_num_rows($result1) > 0) {
              while($row1 = mysqli_fetch_array($result1)) {
                  $labelName = $row1["labelName"];
                  $labelID = $row1["labelID"];
                  echo $labelName;
                  echo "<br>";
                  echo '<form action="../php/removeLabel.php" method="post" role="form">';
                  echo '<input type="hidden" name="labelID" value="'. $labelID .'">';
                  echo '<button type="submit">Remove</button></form>'; 
                  echo "<br>";
              }
            }
          }
        ?>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Album</h3>

        <?php
          $sql2 = "SELECT * FROM albums";

          if ($result2 = mysqli_query($conn, $sql2)) {
            if (mysqli_num_rows($result2) > 0) {
              while($row2 = mysqli_fetch_array($result2)) {
                  $albumName = $row2["albumName"];
                  $albumID = $row2["albumID"];
                  echo $albumName;
                  echo "<br>";
                  echo '<form action="../php/removeAlbum.php" method="post" role="form">';
                  echo '<input type="hidden" name="albumID" value="'. $albumID .'">';
                  echo '<button type="submit">Remove</button></form>'; 
                  echo "<br>";
              }
            }
          }
        ?>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <h3>Remove Track</h3>

        <?php
          $sql3 = "SELECT * FROM tracks";

          if ($result3 = mysqli_query($conn, $sql3)) {
            if (mysqli_num_rows($result3) > 0) {
              while($row3 = mysqli_fetch_array($result3)) {
                  $trackName = $row3["trackName"];
                  $trackID = $row3["trackID"];
                  echo $trackName;
                  echo "<br>";
                  echo '<form action="../php/removeTrack.php" method="post" role="form">';
                  echo '<input type="hidden" name="trackID" value="'. $trackID .'">';
                  echo '<button type="submit">Remove</button></form>'; 
                  echo "<br>";
              }
            }
          }
        ?>

      </div>
    </div>

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Music Browser - Jake Taylor</p>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>