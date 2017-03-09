<?php

if (isset($_POST['updateCourse']))
{
	$_SESSION['updateCourse'] = $_POST['updateCourse'];
}

if (isset($_POST['changeCourse']))
{
	unset($_SESSION['updateCourse']);
}

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewUpdateCourseForm($mysqli);

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewUpdateCourseForm($mysqli)
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
                                    getCourseForm($mysqli);
							}
							else
							{
								updateCourseForm($_SESSION['updateCourse'], $mysqli);

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

function updateCourseForm($courseID, $mysqli)
{

	if ($stmt = $mysqli->prepare("SELECT courseCode, courseName, courseDescription, courseYear, courseFacultyID FROM courses WHERE courseID = ?"))
	{
		$stmt->bind_param('i', $courseID);

		if ($stmt->execute())
		{
			$stmt->bind_result($courseCode, $courseName, $courseDescription, $courseYear, $courseFacultyID);
			$stmt->store_result();
			$stmt->fetch();

			$courseFacultyName = getFacultyLastName($courseFacultyID, $mysqli);

    		generateFormStart("../includes/userFunctions/updateCourse", "post"); 
				generateFormHiddenInput("courseID", $courseID);
				generateFormInputDiv("Course Code", "text", "courseCode", $courseCode, NULL, NULL, NULL, "Course Name");
				generateFormInputDiv("Course Name", "text", "courseName", $courseName, NULL, NULL, NULL, "Course Name");
				generateFormTextAreaDiv("Course Description", "courseDescription", "5", $courseDescription);
        		generateFormInputDiv("Course Year", "number", "courseYear", $courseYear, NULL, NULL, NULL, "Course Year");
			generateFormStartSelectDiv("Faculty Name", "courseFacultyID");
   		         getFacultyList($courseFacultyName, $mysqli);
       		generateFormEndSelectDiv();
       			generateFormButton(NULL, "Update Course");
		    generateFormEnd();
		}
		else
		{
			echo "Inside Execute query failed";
		}
	}
	else
	{
		echo $mysqli->error;
	}
}

function getFacultyLastName($courseFacultyID, $mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT userFirstName, userLastName FROM users WHERE userID = ?"))
	{
		$stmt->bind_param('i', $courseFacultyID);

		if ($stmt->execute())
		{
			$stmt->bind_result($userFirstName, $userLastName);

			$stmt->store_result();

			$stmt->fetch();

			return "$userLastName";
		}
	}
}

function getFacultyList($selected, $mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT userID, userFirstName, userLastName FROM users"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($userID, $userFirstName, $userLastName);
			$stmt->store_result();

			while ($stmt->fetch())
			{
				if ($selected == $userLastName)
				{
   		     		generateFormOption($userID, "$userLastName, $userFirstName", NULL, "selected");
				}
				else
				{
       		 		generateFormOption($userID, "$userLastName, $userFirstName");
				}
			}
		}
	}
}

function getCourseForm($mysqli)
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("Course Description", "updateCourse");
			getCourseList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Select Course");
    generateFormEnd();
}

function getCourseList($mysqli)
{

	if ($stmt = $mysqli->prepare("SELECT courseID, courseName FROM courses"))
    {
		if ($stmt->execute())
		{
			$stmt->bind_result($courseID, $courseName);

			while ($stmt->fetch())
			{
        		generateFormOption($courseID, $courseName);
			}
		}
	}
}

?>
