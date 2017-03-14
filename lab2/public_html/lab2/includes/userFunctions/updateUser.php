<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	updateUserAccount($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
   	header('Location: ../../pages/updateuser');
}

function updateUserAccount($mysqli)
{
	if (isset($_POST['modUserID'], $_POST['userEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userRole'])) 
	{
		$userID = $_POST['modUserID'];
    	$userEmail = $_POST['userEmail'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userRole = $_POST['userRole'];

		if ($stmt = $mysqli->prepare("SELECT userPassword, userSalt FROM users WHERE userID = ?"))
		{
			// Get current passwoord (hashed) and user's salt
			$stmt->bind_param('i', $userID);

			if ($stmt->execute())
			{
				$stmt->bind_result($userPassword, $userSalt);
				$stmt->store_result();

				$stmt->fetch();
			}
		}

		if (isset($_POST['userPassword']) && !empty($_POST['userPassword']))
		{
			// If user typed new password, overwrite the one in the DB
			$userPassword = $_POST['userPassword'];
			$userPassword = hash("sha512", $userPassword . $randomSalt);			
		}
		
		if ($stmt = $mysqli->prepare("UPDATE users SET userEmail = ?, userFirstName = ?, userLastName = ?, userIsFaculty = ?, userPassword = ? WHERE userID = ?"))
		{
			// Update the user
			$stmt->bind_param('sssisi', $userEmail, $userFirstName, $userLastName, $userRole, $userPassword, $userID);

			if ($stmt->execute())
			{
				$_SESSION['success'] = "User account updated";
		   		header('Location: ../../pages/updateuser');
			}
			else
			{
   		 		$error = "Account could not be updated"; 
		   	   	header('Location: ../../pages/error?error=' . $error);
			}
		}
		else
		{
   			$error = "Account could not be updated, SQL Update failed"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
    }
	else
	{
   		$error = "Account could not be updated, data not sent"; 
   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
