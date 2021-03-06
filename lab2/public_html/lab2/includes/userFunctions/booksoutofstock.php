<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAllOutOfStockBooksTable($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}

function viewAllOutOfStockBooksTable($mysqli)
{
	echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	     ';
						// Call Session Message code and Panel Heading here
                        displayPanelHeading("View Out Of Stock Books");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#addMaterialType" data-toggle="tab">View Out Of Stock Books</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">';

                                    echo '<h4>View Out Of Stock Books</h4>';
                            echo '
                                
                                <div class="tab-pane fade in active" id="userTable">';

                                    viewAllOutOfStockBooks($mysqli);
echo '
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
';

}

function viewAllOutOfStockBooks($mysqli)
{
	$userTable = "profile";
    echo '
         	<!-- DataTables CSS -->
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!-- DataTables JavaScript -->
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
  
			<table width="100%" class="table table-striped table-bordered table-hover" id="' . $userTable . '">
            	<thead>
                	<tr>
			<th>ISBN</th>
                    	<th>Title</th>
                        <th>Author</th>
                        <th>Publisher/th>
                        <th>Year</th>
			<th>Publisher Page</th>
                        <th>Amazon Link</th>
                        <th>Course Used</th>
			</tr>
                </thead>
            <tbody>
        ';          
           		getOutOfStockBooks($mysqli);
    echo ' 
           	</tbody>
          </table>
                                <!-- /.table-responsive -->

                <!-- Page-Level Demo Scripts - Tables - Use for reference -->
                <script>
                $(document).ready(function() {
                    $(\'#' . $userTable . '\').DataTable({
                        responsive: true
                    });
                });
                </script>
        ';

}

function getOutOfStockBooks($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT bookISBN, bookName, bookAuthor, bookPublisher, bookYear, bookPublisherLink, bookAmazonLink, bookCourse FROM books WHERE bookStock = 0"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($bookISBN, $bookName, $bookAuthor, $bookPublisher, $bookYear, $bookPublisherLink, $bookAmazonLink, $bookCourse);

			while ($stmt->fetch())
			{
        		echo '
                        <tr class="gradeA">
						<td>' . $bookISBN . '</td>
           	        	<td>' . $bookName . '</td>
           	        	<td>' . $bookAuthor . '</td>
           	        	<td>' . $bookPublisher . '</td>
           	        	<td>' . $bookYear . '</td>
           	        	<td>' . '<a href=" ' .  $bookPublisherLink . '">Publisher Page</a>' .  '</td>
           		      	<td>' . '<a href=" ' .  $bookAmazonLink . '">Amazon  Page</a>' .  '</td>
               	    	<td>' . $bookCourse . '</td>
					</tr>
       	 	     ';
			}
		}
	}
}

?>
