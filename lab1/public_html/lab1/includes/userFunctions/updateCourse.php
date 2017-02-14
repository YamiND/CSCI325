<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	updateCourse();
}
else
{
	echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

   	$_SESSION['fail'] = 'Course modification Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function updateCourse()
{
	if (isset($_POST['oldCourseName'], $_POST['courseCode'], $_POST['courseName'], $_POST['courseDescription'], $_POST['courseDescriptionYear'], $_POST['courseFaculty'])) 
	{
		
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
				header('Location: ../../pages/updatecourse');
			}
		}
		
		$oldCourseName = $_POST['oldCourseName'];
		$courseCode = $_POST['courseCode'];
    	$courseName = $_POST['courseName'];
		$courseDescription = $_POST['courseDescription'];
		$courseDescriptionYear = $_POST['courseDescriptionYear'];
		$courseFaculty = $_POST['courseFaculty'];


		$fileName = COURSECSV;
        $newArray = array_map('str_getcsv', file($fileName));

        $success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][0] == $oldCourseName) 
            {   
                    $success = true;
                    break;
            }   
        }    

        if (($success) && ($oldCourseName != $courseName))
        {   
            $error = "Course already exists, can't change"; 
            header('Location: ../../pages/error?error=' . $error);
			return;
        }
		else
		{
 	       	for ($i = 0; $i < count($newArray); $i++)
			{  
            	if ($newArray[$i][0] == $courseCode) 
            	{   
                	removeLine(COURSECSV, $courseCode);
            	}   
        	}  
		}

		$handle = fopen($fileName, "a");
		fputcsv($handle, array($courseCode, $courseName, $courseDescription, $courseDescriptionYear, $courseFacultyName));
		fclose($handle);
//		$_SESSION['success'] = "Course updated";
   		header('Location: ../../pages/updatecourse');
    }
	else
	{
    		$error = "Course already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
