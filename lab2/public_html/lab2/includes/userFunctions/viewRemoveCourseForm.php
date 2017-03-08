<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewRemoveCourseForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveCourseForm()
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
                                <li class="active"><a href="#administrator" data-toggle="tab">User</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    removeCourseForm();
                                    
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

function removeCourseForm()
{
    generateFormStart("../includes/userFunctions/removeCourse", "post"); 
        generateFormStartSelectDiv("Course Name", "courseCode");
			getCourseList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove Course");
    generateFormEnd();
}

function getCourseList()
{
	$fileName = COURSECSV;

    $newArray = array_map('str_getcsv', file($fileName));

	for ($i = 0; $i < count($newArray); $i++)
    {
        generateFormOption($newArray[$i][0], $newArray[$i][1]);
	}
}

?>
