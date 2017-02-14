<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	addCourse();
}
else
{
	echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

   	$_SESSION['fail'] = 'Course Creations Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function addCourse()
{
	if (isset($_POST['courseNumber'], $_POST['courseTitle'], $_POST['courseDescription'], $_POST['courseYear'], $_POST['courseFaculty'])) 
	{
		//echo "I'm here";
		
		//go through posts
		foreach($_POST as $key => $value)
		{
			//check for null
			if (!empty($value))
			{
				//strip slashes
				$value=stripslashes($value);
			
				//strip html shit
				$value = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($value))))));
				
				//trim spaces from right end of string
				$value = rtrim($value);
				
				//trim spacs from left end of string
				$value = ltrim($value);
			}
			else
			{
				//set session variable and redirect to add course
				$_SESSION['fail'] = 'I can\'t process html characters, slashes, spaces at the end, or null values. Try fixing your input.';
				header('Location: ../../pages/addcourse');
			}
		}
		
    	$courseNumber = $_POST['courseNumber'];
		$courseTitle = $_POST['courseTitle'];
		$courseDescription = $_POST['courseDescription'];
		$courseYear = $_POST['courseYear'];
		$courseFaculty = $_POST['courseFaculty'];

 		$fileName = COURSECSV;
   		$newArray = array_map('str_getcsv', file($fileName));
		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][1] == $courseNumber) 
            {   
                    $success = false;
					break;
            }   
        }    	

		if ($success)
		{
    		$error = "Course already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
		else
		{
			$fileName = COURSECSV;

			$handle = fopen($fileName, "a");

			fputcsv($handle, array($courseNumber, $courseTitle, $courseDescription, $courseYear, $courseFaculty));
			
			fclose($handle);

			$_SESSION['success'] = "Course created";

   	   		header('Location: ../../pages/addcourse');
		}
    }
	else
	{
    		$error = "Course already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
