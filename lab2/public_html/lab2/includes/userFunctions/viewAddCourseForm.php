<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAddCourseForm();
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewAddCourseForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Add Course");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Add Course</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    addCourseForm();
                                    
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

function addCourseForm()
{
    generateFormStart("../includes/userFunctions/addCourse", "post"); 
        generateFormInputDiv("Course Number", "text", "courseNumber", NULL, NULL, NULL, NULL, "Course Number");
        generateFormInputDiv("Course Title", "text", "courseTitle", NULL, NULL, NULL, NULL, "Course Title");
		generateFormTextAreaDiv("Course Description", "courseDescription", "5");	
        generateFormInputDiv("Course Description Year", "number", "courseYear", date('Y'), NULL, NULL, NULL, "Course Description Year");
		generateFormStartSelectDiv("Faculty Last Name", "courseFaculty");
               getFacultyList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Add Course");
   generateFormEnd();
}

function getFacultyList()
{
    $fileName = USERCSV;

    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {   
        $userRoleID = $newArray[$i][5];

        if ($userRoleID == 0)
        {   
            $userLastName = $newArray[$i][1];
            generateFormOption($userLastName, $userLastName);
        }   
    }   
}

?>
