<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	removeBook();
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

function removeBook()
{
	if (isset($_POST['bookISBN'])) 
	{
    	$bookISBN = $_POST['bookISBN'];

 		$fileName = BOOKCSV;

    	$newArray = array_map('str_getcsv', file($fileName));

		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][0] == $bookISBN) 
            {   
				removeLine(BOOKCSV, $bookISBN);
				$success = true;
            }   
        }    	

		if ($success)
		{
			$_SESSION['success'] = "Book removed";
   	   		header('Location: ../../pages/removebooks');
		}
		else
		{
    		$error = "Book does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
    }
	else
	{
    		$error = "Book does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
