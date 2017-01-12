<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($line2) == true) 
{
	createUserAccount();
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

function createUserAccount()
{
	if (isset($_POST['userEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userPassword'], $_POST['userRole'], $_POST['userName'])) 
	{
    		$userEmail = $_POST['userEmail'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userPassword = $_POST['userPassword'];
		$userName = $_POST['userName'];
		$userRole = $_POST['userRole'];

 		$fileName = '../../../private/lab1/users.csv';
    		$newArray = array_map('str_getcsv', file($fileName));
		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][3] == $userEmail) 
            {   
                    $success = false;
					break;
            }   
        }    	

		if ($success)
		{
    		$error = "Account already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
		else
		{

			$csvVar = $userFirstName . "," . $userLastName . "," . $userName . "," . $userEmail . "," . $userPassword . "," . $userRole;			

			$password = hash('sha512', $userPassword);
			$fileName = "../../../../private/lab1/users.csv";

//			$fileName = '../../../../private/lab1/users.csv';
//			$fileName = "text.csv";
			$handle = fopen($fileName, "a");

			fputcsv($handle, array($userFirstName, $userLastName, $userName, $userEmail, $password, $userRole));
			
			fclose($handle);

			$_SESSION['success'] = "User account created";

   	   		header('Location: ../../pages/adduser');
		}
    }
	else
	{
    		$error = "Account already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
