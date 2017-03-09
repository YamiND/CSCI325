<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAllCoursesTable($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}

function viewAllCoursesTable($mysqli)
{
	echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	     ';
						// Call Session Message code and Panel Heading here
                        displayPanelHeading("View All Courses");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#addMaterialType" data-toggle="tab">View all Courses</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">';

                                    echo '<h4>View all Courses</h4>';
                            echo '
                                
                                <div class="tab-pane fade in active" id="userTable">';

                                    viewAllCourses($mysqli);
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

function viewAllCourses($mysqli)
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
                        <th>Course Number</th>
                    	<th>Course Name</th>
                        <th>Course Description</th>
                        <th>Course Description Year</th>
                        <th>Course Faculty Last Name</th>
                    </tr>
                </thead>
            <tbody>
        ';          
           		getCourses($mysqli);
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

function getCourses($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT courseCode, courseName, courseDescription, courseYear, courseFacultyID FROM courses"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($courseCode, $courseName, $courseDescription, $courseYear, $courseFacultyID);

			$stmt->store_result();

			while ($stmt->fetch())
			{
    			echo '
               		<tr class="gradeA">
                   	<td>' . $courseCode . '</td>
                   <td>' . $courseName . '</td>
                   <td>' . $courseDescription . '</td>
                   <td>' . $courseYear . '</td>
                   <td>' . getFacultyName($courseFacultyID, $mysqli) . '</td>
              		 </tr>
		             ';
			}
		}
	}
}

function getFacultyName($courseFacultyID, $mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT userFirstName, userLastName FROM users WHERE userID = ?"))
	{
		$stmt->bind_param('i', $courseFacultyID);

		if ($stmt->execute())
		{
			$stmt->bind_result($userFirstName, $userLastName);
			$stmt->store_result();

			$stmt->fetch();

			return "$userLastName, $userFirstName";
		}
	}

}

?>
