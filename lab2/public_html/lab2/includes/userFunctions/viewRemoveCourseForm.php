<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewRemoveCourseForm($mysqli);

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveCourseForm($mysqli)
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Remove Course");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Remove Course</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    removeCourseForm($mysqli);
                                    
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

function removeCourseForm($mysqli)
{
    generateFormStart("../includes/userFunctions/removeCourse", "post"); 
        generateFormStartSelectDiv("Course Name", "courseID");
			getCourseList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove Course");
    generateFormEnd();
}

function getCourseList($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT courseID, courseName FROM courses"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($courseID, $courseName);
			$stmt->store_result();
			
			while ($stmt->fetch())
			{
        		generateFormOption($courseID, $courseName);
			}
		}
	}
}

?>
