<?php

include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	removeUserAccount();
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

function removeUserAccount()
{
	if (isset($_POST['userEmail'])) 
	{
    	$userEmail = $_POST['userEmail'];

 		$fileName = USERCSV;

    	$newArray = array_map('str_getcsv', file($fileName));

		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][3] == $userEmail) 
            {   
				removeLine(USERCSV, $userEmail);
				$success = true;
            }   
        }    	

		if ($success)
		{
			$_SESSION['success'] = "User account removed";
   	   		header('Location: ../../pages/removeuser');
		}
		else
		{
    		$error = "Account does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);

		}
    }
	else
	{
    		$error = "Account does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
