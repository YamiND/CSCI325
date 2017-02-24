<?php

define("SECURE", FALSE);
define("USERCSV", "/var/www/dropcables/public_html/CSCI325/lab1/private/lab1/users.csv");
define("COURSECSV", "/var/www/dropcables/public_html/CSCI325/lab1/private/lab1/courses.csv");
define("BOOKCSV", "/var/www/dropcables/public_html/CSCI325/lab1/private/lab1/books.csv");

//define("USERCSV", "/var/www/html/CSCI325/lab1/private/lab1/users.csv");
//define("COURSECSV", "/var/www/html/CSCI325/lab1/private/lab1/courses.csv");
//define("BOOKCSV", "/var/www/html/CSCI325/lab1/private/lab1/books.csv");

function sec_session_start() 
{
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    session_name($session_name);
 
    // This stops JavaScript being able to access the session id.
    //$secure = SECURE;
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../pages/error?error=Could not initiate a safe session (ini_set)"); // TODO: We need to fix the error page
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    //session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function login($userEmail, $password) 
{

	//$fileName = '../../../private/lab1/users.csv';
	$fileName = USERCSV;
	$userArray = array_map('str_getcsv', file($fileName));

	$success = false;

       	$password = hash('sha512', $password);
		for ($i = 0; $i < count($userArray); $i++)
		{
	    		if ($userArray[$i][3] == $userEmail) 
			{
				if ($userArray[$i][4] == $password)
				{
            				$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$roleID = $userArray[$i][5];
            				$roleID = preg_replace("/[^0-9]+/", "", $roleID);
            				$_SESSION['roleID'] = $roleID;
		    			$_SESSION['userEmail'] = $userEmail;
            				$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
        				$success = true;
        				break;
				}
    			}
		}	
	if ($success) 
	{
		return true;
	} 
	else 
	{
    	return false;
	}
}

function login_check() 
{
	$valid = false;
	if (isset($_SESSION['userEmail'], $_SESSION['roleID'], $_SESSION['login_string'])) 
    {
       	$login_string = $_SESSION['login_string'];
	 	$userEmail = $_SESSION['userEmail'];
	 	$roleID = $_SESSION['roleID'];	
		$user_browser = $_SERVER['HTTP_USER_AGENT'];

//		$fileName = '../../../private/lab1/users.csv';
		$fileName = USERCSV;

		$userArray = array_map('str_getcsv', file($fileName));

		for ($i = 0; $i < count($userArray); $i++)
		{
            if ($userArray[$i][3]==$userEmail)
            {   
				$userPassword = $userArray[$i][4];

				$login_check = hash('sha512', $userPassword . $user_browser);
				
				if ($login_check == $login_string)
				{
					$valid = true;
				}
				else
				{
					$valid = false;
				}
            }   
        }
		return $valid; 	
	}
}

function removeLine($file, $string)
{
    $i=0;$array=array();
    
    $read = fopen($file, "r") or die("can't open the file");
    while(!feof($read)) 
    {   
        $array[$i] = fgets($read);  
        ++$i;
    }   

    fclose($read);
    
    $write = fopen($file, "w") or die("can't open the file");

    foreach($array as $a) 
    {   
        if(!strstr($a,$string)) fwrite($write,$a);
    }
    fclose($write);
}

?>
