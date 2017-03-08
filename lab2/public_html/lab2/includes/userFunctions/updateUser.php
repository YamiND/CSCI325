<?php
include_once '../dbConnect.php';
include_once '../functions.php';


sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	updateUserAccount();
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

function updateUserAccount()
{
	if (isset($_POST['userEmail'], $_POST['oldEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userRole'], $_POST['userName'])) 
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
		$oldEmail = $_POST['oldEmail'];
    	$userEmail = $_POST['userEmail'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userName = $_POST['userName'];
		$userRole = $_POST['userRole'];


		$fileName = USERCSV;
        $newArray = array_map('str_getcsv', file($fileName));

        $success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][3] === $userEmail) 
            {   
                    $success = true;
                    break;
            }   
        }    

        if (($success) && ($oldEmail != $userEmail))
        {   
            $error = "Email already exists, can't change"; 
            header('Location: ../../pages/error?error=' . $error);
			return;
        }
		else
		{

 	       	for ($i = 0; $i < count($newArray); $i++)
			{   
            	if ($newArray[$i][3] == $userEmail) 
            	{   
					if (!empty($_POST['userPassword']))
					{
						$userPassword = $_POST['userPassword'];	
						$password = hash('sha512', $userPassword);
					}
					else
					{
						$password = $newArray[$i][4];
					}
                	removeLine(USERCSV, $userEmail);
            	}   
        	}  
		}

		$handle = fopen($fileName, "a");
		fputcsv($handle, array($userFirstName, $userLastName, $userName, $userEmail, $password, $userRole));
		fclose($handle);
		$_SESSION['success'] = "User account updated";
   		header('Location: ../../pages/updateuser');
    }
	else
	{
    		$error = "Account already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
