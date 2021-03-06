<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAllFacultyTable($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}

function viewAllFacultyTable($mysqli)
{
	echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	     ';
						// Call Session Message code and Panel Heading here
                        displayPanelHeading("View All Faculty");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#addMaterialType" data-toggle="tab">View all Faculty</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">';

                                    echo '<h4>View all Faculty</h4>';
                            echo '
                                
                                <div class="tab-pane fade in active" id="userTable">';

                                    viewAllFaculty($mysqli);
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

function viewAllFaculty($mysqli)
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
                        <th>Last Name</th>
                    	<th>First Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
            <tbody>
        ';          
           		getUsers($mysqli);
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

function getUsers($mysqli)
{
    if ($stmt = $mysqli->prepare("SELECT userFirstName, userLastName, userEmail FROM users WHERE userIsFaculty = 1"))
    {   
        if ($stmt->execute())
        {   
            $stmt->bind_result($userFirstName, $userLastName, $userEmail);
            $stmt->store_result();
    

                while ($stmt->fetch())
                {   
                    echo '
                       <tr class="gradeA">
                           <td>' . $userLastName . '</td>
                           <td>' . $userFirstName . '</td>
                           <td>' . $userEmail . '</td>
                       </tr>
                     ';
                }   
            }   
        }   

}

?>
