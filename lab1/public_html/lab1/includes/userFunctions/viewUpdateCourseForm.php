<?php

if (isset($_POST['updateCourse']))
{
	$_SESSION['updateCourse'] = $_POST['updateCourse'];
}

if (isset($_POST['changeCourse']))
{
	unset($_SESSION['updateCourse']);
}

function checkPermissions()
{
    if (login_check() == true)
    {
        viewUpdateCourseForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewUpdateCourseForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Update Course");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Update Course</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
							if (!isset($_SESSION['updateCourse']))
							{
                                    getCourseForm();
							}
							else
							{
								updateCourseForm($_SESSION['updateCourse']);

								echo "<br>";
				
								generateFormStart("", "post"); 
                                    generateFormButton("changeCourse", "Change Course");
                                generateFormEnd();

							}
                                    
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

function updateCourseForm($courseCode)
{
	unset($_SESSION['updateCourse']);

	$fileName = COURSECSV;

    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {   
        if ($newArray[$i][0] == $courseCode) 
        {   
	        $courseName = $newArray[$i][1];
	        $courseDescription = $newArray[$i][2];
	        $courseDescriptionYear = $newArray[$i][3];
	        $courseFacultyName = $newArray[$i][4];

    		generateFormStart("../includes/userFunctions/updateCourse", "post"); 
				generateFormHiddenInput("oldCourseName", $courseName);
				generateFormHiddenInput("courseCode", $courseCode);
				generateFormInputDiv("Course Name", "text", "courseName", $courseName, NULL, NULL, NULL, "Course Name");
				generateFormTextAreaDiv("Course Description", "courseDescription", "5", $courseDescription);
        		generateFormInputDiv("Course Description Year", "number", "courseDescriptionYear", $courseDescriptionYear, NULL, NULL, NULL, "Course Description Year");
			generateFormStartSelectDiv("Faculty Last Name", "courseFaculty");
   		         getFacultyList($courseFacultyName);
       		generateFormEndSelectDiv();
       			generateFormButton(NULL, "Update Course");
		    generateFormEnd();

        }   
    }    
}

function getFacultyList($selected)
{
    $fileName2 = USERCSV;

    $newArray = array_map('str_getcsv', file($fileName2));

    for ($i = 0; $i < count($newArray); $i++)
    {   
		$userRoleID = $newArray[$i][5];

		$userLastName = $newArray[$i][1];

		if ($userRoleID == 0)
		{
			if ($selected == $userLastName)
			{
        		generateFormOption($userLastName, $userLastName, NULL, "selected");
			}
			else
			{
        		generateFormOption($userLastName, $userLastName);
			}
		}
    }
}

function getCourseForm()
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("Course Description", "updateCourse");
			getCourseList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Select Course");
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
