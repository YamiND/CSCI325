<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	removeCourse();
}
else
{
	echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function removeCourse()
{
	if (isset($_POST['courseCode'])) 
	{
    	$courseCode = $_POST['courseCode'];

 		$fileName = COURSECSV;

    	$newArray = array_map('str_getcsv', file($fileName));

		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][0] == $courseCode) 
            {   
				removeLine(COURSECSV, $courseCode);
				$success = true;
            }   
        }    	

		if ($success)
		{
			$_SESSION['success'] = "Course removed";
   	   		header('Location: ../../pages/removecourse');
		}
		else
		{
    		$error = "Course does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
    }
	else
	{
    		$error = "Course does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
