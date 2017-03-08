<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAllBooksByCourseTable($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}

function viewAllBooksByCourseTable($mysqli)
{
	echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	     ';
						// Call Session Message code and Panel Heading here
                        displayPanelHeading("View All Books");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#addMaterialType" data-toggle="tab">View All Books By Course</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">';

                                    echo '<h4>View All Books By Course</h4>';
                            echo '
                                
                                <div class="tab-pane fade in active" id="userTable">';

                                    viewAllBooksByCourse($mysqli);
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

function viewAllBooksByCourse($mysqli)
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
                        <th>Course Used</th>
			<th>ISBN</th>
                    	<th>Title</th>
                        <th>Author</th>
                        <th>Publisher/th>
                        <th>Year</th>
			<th>Publisher Page</th>
                        <th>Amazon Link</th>
                        <th>Number In Stock</th>
                    </tr>
                </thead>
            <tbody>
        ';          
           		getBooksByCourse($mysqli);
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

function getBooksByCourse($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT bookISBN, bookCourse, bookName, bookAuthor, bookPublisher, bookYear, bookPublisherLink, bookAmazonLink, bookStock FROM books"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($bookISBN, $bookCourse, $bookName, $bookAuthor, $bookPublisher, $bookYear, $bookPublisherLink, $bookAmazonLink, $bookStock);
			$stmt->store_result();
			while ($stmt->fetch())
			{
    			echo '
       		        <tr class="gradeA">
           		        <td>' . $bookCourse . '</td>
					   <td>' . $bookISBN . '</td>
           		        <td>' . $bookName . '</td>
               		    <td>' . $bookAuthor . '</td>
	                   <td>' . $bookPublisher . '</td>
   		                <td>' . $bookYear . '</td>
       		            <td>' . '<a href=" ' .  $bookPublisherLink . '">Publisher Page</a>' .  '</td>
           		        <td>' . '<a href=" ' .  $bookAmazonLink . '">Amazon  Page</a>' .  '</td>		
               		    <td>' . $bookStock . '</td>
				  </tr>
       	      ';
			}
		}
    }    
}

?>
