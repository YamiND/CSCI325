<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	addCourse($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Course Creations Failed, invalid permissions';
   	header('Location: ../../pages/addcourse');
}

function addCourse($mysqli)
{
	$duplicate = false;

	if (isset($_POST['courseNumber'], $_POST['courseTitle'], $_POST['courseDescription'], $_POST['courseYear'], $_POST['courseFaculty'])) 
	{
    	$courseNumber = $_POST['courseNumber'];
		$courseTitle = $_POST['courseTitle'];
		$courseDescription = $_POST['courseDescription'];
		$courseYear = $_POST['courseYear'];
		$courseFaculty = $_POST['courseFaculty'];

		if ($stmt = $mysqli->prepare("SELECT courseID FROM courses WHERE courseName = ?"))
		{
			$stmt->bind_param('s', $courseTitle);
			$stmt->store_result();
			if ($stmt->execute())
			{
				if ($stmt->num_rows > 0)
				{
					$duplicate = true;
				}
				else
				{
					$duplicate = false;
				}
			}
			$stmt->close();
		}

		if (!$duplicate)
		{
			if ($stmt = $mysqli->prepare("INSERT INTO courses (courseCode, courseName, courseDescription, courseYear, courseFacultyID) VALUES (?, ?, ?, ?, ?)"))
			{
				$stmt->bind_param('ssssi', $courseNumber, $courseTitle, $courseDescription, $courseYear, $courseFaculty);

				if ($stmt->execute())
				{
					$_SESSION['success'] = "Course added";
			   	   	header('Location: ../../pages/addcourse');
				}
				else
				{
    				$error = "Can not add course, database insert faliure"; 
			   	   	header('Location: ../../pages/error?error=' . $error);
				}
			}
			else
			{
    			$error = "Can not add course, database insert query fail"; 
		   	   	header('Location: ../../pages/error?error=' . $error);
			}
		}
		else
		{
    		$error = "Can not add course, already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
    }
	else
	{
    		$error = "Can not add course, data not sent"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
