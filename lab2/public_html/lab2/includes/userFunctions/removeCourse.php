<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	removeCourse($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
   	header('Location: ../../pages/removecourse');

	return;
}

function removeCourse($mysqli)
{
	if (isset($_POST['courseID'])) 
	{
    	$courseID = $_POST['courseID'];

		if ($stmt = $mysqli->prepare("DELETE FROM courses WHERE courseID = ?"))
		{
			$stmt->bind_param('i', $courseID);

			if ($stmt->execute())
			{
				$_SESSION['success'] = "Course removed";
   		   		header('Location: ../../pages/removecourse');
			}
			else
			{
   		 		$error = "Course does not exist, invalid ID"; 
	   		   	header('Location: ../../pages/error?error=' . $error);
			}
		}
    }
	else
	{
    		$error = "Course data not sent"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
