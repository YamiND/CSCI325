<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if ((login_check($mysqli) == true) || ($_POST['code'] == 1337))
{
	if (isset($_POST['code']) && $_POST['code'] == 1337)
	{
		createUserAccount($_POST['code']);
	}
	else
	{
		createUserAccount();
	}
}
else
{
   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function createUserAccount($code = NULL)
{
	if (isset($_POST['userEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userPassword'], $_POST['userRole'], $_POST['userName'])) 
	{
		
	 foreach($_POST as $key => $value)
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

			$password = hash('sha512', $userPassword);
			$fileName = "../../../../private/lab1/users.csv";

			$handle = fopen($fileName, "a");

			fputcsv($handle, array($userFirstName, $userLastName, $userName, $userEmail, $password, $userRole));
			
			fclose($handle);

			$_SESSION['success'] = "User account created";

			if($code == 1337)
			{
   	   			header('Location: ../../pages/register_form');
			}
			else
			{
   	   			header('Location: ../../pages/adduser');

			}
		}
    }
	else
	{
    		$error = "Account already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
