<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAllBooksByCourseTable();
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}

function viewAllBooksByCourseTable()
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

                                    viewAllBooksByCourse();
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

function viewAllBooksByCourse()
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
           		getBooksByCourse();
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

function getBooksByCourse()
{
	$fileName = BOOKCSV;
    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {  
		$ISBN = $newArray[$i][0];
		$Title = $newArray[$i][1];
		$Author = $newArray[$i][2];
		$Publisher = $newArray[$i][3];	
		$Year = $newArray[$i][4];
                $publisherLink = $newArray[$i][5];
                $amazonLink = $newArray[$i][6];
                $courseUsed = $newArray[$i][7];
                if ($courseUsed==0)
                {
	                $courseUsed="CSCI";
                }
                else
                {
	                $courseUsed="MATH";
                }
                $numberInStock = $newArray[$i][8]; 

    	echo '
               <tr class="gradeA">
                   <td>' . $courseUsed . '</td>
		   <td>' . $ISBN . '</td>
                   <td>' . $Title . '</td>
                   <td>' . $Author . '</td>
                   <td>' . $Publisher . '</td>
                   <td>' . $Year . '</td>
                   <td>' . '<a href=" ' .  $publisherLink . '">Publisher Page</a>' .  '</td>
                   <td>' . '<a href=" ' .  $amazonLink . '">Amazon  Page</a>' .  '</td>		
                   <td>' . $numberInStock . '</td>
		  </tr>
             ';
    }    
}

?>
