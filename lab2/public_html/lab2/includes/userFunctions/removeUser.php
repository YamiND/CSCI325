<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	removeUserAccount($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
   	header('Location: ../../pages/removeuser');

	return;
}

function removeUserAccount($mysqli)
{
	if (isset($_POST['userID']) && !empty($_POST['userID']) )
	{
		$userID = $_POST['userID'];

		if ($stmt = $mysqli->prepare("DELETE FROM users WHERE userID = ?"))
		{
			$stmt->bind_param('i', $userID);

			if ($stmt->execute())
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
	else
	{
    		$error = "Account does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
