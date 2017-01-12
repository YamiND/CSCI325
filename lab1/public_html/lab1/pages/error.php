<?php 
    echo '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title>ERROR</title>
            <!-- Header Information, CSS, and JS -->
            ';

            include("../includes/header.php");
    echo '
        </head>
		
        <body>

            <div id="wrapper">

        	<!-- Navigation Menu -->
		';
			include("../includes/navPanel.php");
echo '
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">ERROR</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
			<h3>ERROR PAGE</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
	';
			echo $_GET['error'];
echo '
			
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
                </div>
                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->

        </body>

        </html>
    ';
?>
