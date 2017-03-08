<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	removeBook($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Removing book Failed, invalid permissions';
   	header('Location: ../../pages/removebooks');
}

function removeBook($mysqli)
{
	if (isset($_POST['bookID'])) 
	{
    	$bookID = $_POST['bookID'];

		if ($stmt = $mysqli->prepare("DELETE FROM bookCourseIDs WHERE bookID = ?"))
		{
			$stmt->bind_param('i', $bookID);
			$stmt->execute();
		}

		if ($stmt = $mysqli->prepare("DELETE FROM books WHERE bookID = ?"))
		{
			$stmt->bind_param('i', $bookID);

			if ($stmt->execute())
			{
				$_SESSION['success'] = "Book has been deleted";	
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
	else
	{
    		$error = "Book does not exist"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
