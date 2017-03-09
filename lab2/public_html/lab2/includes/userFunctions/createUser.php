<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if ((login_check($mysqli) == true) || ($_POST['code'] == 1337))
{
	if (isset($_POST['code']) && $_POST['code'] == 1337)
	{
		createUserAccount($_POST['code'], $mysqli);
	}
	else
	{
		createUserAccount(NULL, $mysqli);
	}
}
else
{
   	$_SESSION['fail'] = 'Account Creations Failed, invalid permissions';
   	header('Location: ../../pages/adduser');
}

function createUserAccount($code = NULL, $mysqli)
{
	if (isset($_POST['userEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userPassword'], $_POST['userRole'])) 
	{
		
    	$userEmail = $_POST['userEmail'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userPassword = $_POST['userPassword'];
		$userIsFaculty = $_POST['userRole'];

		$randomSalt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		$hashedPassword = hash("sha512", $userPassword . $randomSalt);

		if ($stmt = $mysqli->prepare("SELECT userEmail FROM users where userEmail = ?"))
		{
			$stmt->bind_param('s', $userEmail);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0)
			{
    			$_SESSION['fail'] = 'Account Creation Failed, Account already exists';
   	   			header('Location: ../../pages/adduser');
			}
			else
			{
    	
				if ($stmt = $mysqli->prepare("INSERT INTO users (userEmail, userPassword, userFirstName, userLastName, userSalt, userIsFaculty) VALUES (?, ?, ?, ?, ?, ?)"))
				{
    				$stmt->bind_param('sssssi', $userEmail, $hashedPassword, $userFirstName, $userLastName, $randomSalt, $userIsFaculty); 

	    			if ($stmt->execute())    // Execute the prepared query.
					{
   						$_SESSION['successs'] = 'Account Creation success';

						if ($code == "1337")
						{
   	   						header('Location: ../../pages/login');
						}
						else
						{
   	   						header('Location: ../../pages/adduser');
						}
					}
					else
					{
    					$error = "Account can not be created, insert failed"; 
				   	   	header('Location: ../../pages/error?error=' . $error);
					}
				}
			}
		}
    }
	else
	{
    		$error = "Account can not be created, data not sent"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
