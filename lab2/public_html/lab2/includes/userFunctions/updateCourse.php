<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	updateCourse($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Course modification Failed, invalid permissions';
   	header('Location: ../../pages/updatecourse');
}

function updateCourse($mysqli)
{
	if (isset($_POST['courseID'], $_POST['courseCode'], $_POST['courseName'], $_POST['courseDescription'], $_POST['courseYear'], $_POST['courseFacultyID'])) 
	{
		$courseID = $_POST['courseID'];
		$courseCode = $_POST['courseCode'];
    	$courseName = $_POST['courseName'];
		$courseDescription = $_POST['courseDescription'];
		$courseYear = $_POST['courseYear'];
		$courseFacultyID = $_POST['courseFacultyID'];

		if ($stmt = $mysqli->prepare("UPDATE courses SET courseCode = ?, courseName = ?, courseDescription = ?, courseYear = ?, courseFacultyID = ? WHERE courseID = ?"))
		{
			$stmt->bind_param('ssssii', $courseCode, $courseName, $courseDescription, $courseYear, $courseFacultyID, $courseID);

			if ($stmt->execute())
			{
				$_SESSION['success'] = "Course updated";
		   		header('Location: ../../pages/updatecourse');
			}
			else
			{
    			$error = "Course can't be updated, update failure";
		   	   	header('Location: ../../pages/error?error=' . $error);
			}
		}
		else
		{
    		$error = "Course can't be updated, database query failure";
		   	header('Location: ../../pages/error?error=' . $error);
		}
    }
	else
	{
    		$error = "Course can't be updated, data not sent";
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
