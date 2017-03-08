<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SUDOSQUAD LAB #1</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Lab #1</a>
        </div>
	<?php include 'menu.php';?>
        <div id="navbar" class="navbar-collapse collapse">
	<?php include 'login.php';?>	
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
		<?php

			if (($file = fopen("users.csv", "r")) !== FALSE) {
				while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
					$num = count($data);
					usort($data[0]);
					echo "------------------------------------------------------------<br />\n";
					for ($x=0; $x < $num; $x++) {
						if ($x == 0){
							echo "<b>Last Name: </b>".$data[$x] . "<br />\n";
						} elseif ($x == 1) {
							echo "<b>First Name: </b>".$data[$x] . "<br />\n";
						} elseif ($x == 2) {
							echo "<b>Username: </b>".$data[$x] . "<br />\n";
						} elseif ($x == 3) {
							echo "<b>Email: </b>".$data[$x] . "<br />\n";
						} elseif ($x == 4) {
							echo "<b>Status: </b>".$data[$x] . "<br />\n";
						}
					
					}
				}
				
				fclose($handle);
			}
		?>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Add User &raquo;</a></p>
			<p>Click here to add a User.</p>
        </div>
        <div class="col-md-4">
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Remove User &raquo;</a></p>
			<p>Click here to remove a User.</p>
       </div>
        <div class="col-md-4">
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Update User &raquo;</a></p>
			<p>Click here to update a User.</p>
        </div>
		<div class="col-md-4">
			<p><a class="btn btn-primary btn-lg" href="#" role="button">List All Users &raquo;</a></p>
			<p>Click here to list all Users.</p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2016 Company, Inc.</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
