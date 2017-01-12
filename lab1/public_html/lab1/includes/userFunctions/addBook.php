<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	addBook();
}
else
{
	echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

   	$_SESSION['fail'] = 'Creations Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function addBook()
{
	if (isset($_POST['bookISBN'], $_POST['bookTitle'], $_POST['bookAuthor'], $_POST['bookPublisher'], $_POST['bookYear'], $_POST['bookPublisherLink'], $_POST['bookAmazonLink'], $_POST['bookCourseType'], $_POST['bookStock'])) 
	{
    	$bookISBN = $_POST['bookISBN'];
		$bookTitle = $_POST['bookTitle'];
		$bookAuthor = $_POST['bookAuthor'];
		$bookPublisher = $_POST['bookPublisher'];
		$bookYear = $_POST['bookYear'];
		$bookPublisherLink = $_POST['bookPublisherYear'];
		$bookAmazonLink = $_POST['bookAmazonLink'];
		$bookCourseType = $_POST['bookCourseType'];
		$bookStock = $_POST['bookStock'];

 		$fileName = BOOKCSV;
   		$newArray = array_map('str_getcsv', file($fileName));
		$success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][0] == $bookISBN) 
            {   
                    $success = true;
					break;
            }   
        }    	

		if ($success)
		{
    		$error = "Book already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
		}
		else
		{
			$fileName = BOOKCSV;

			$handle = fopen($fileName, "a");

			fputcsv($handle, array($bookISBN, $bookTitle, $bookAuthor, $bookPublisher, $bookYear, $bookPublisher, $bookAmazonLink, $bookCourseType, $bookStock));
			
			fclose($handle);

			$_SESSION['success'] = "Book created";

   	   		header('Location: ../../pages/addbooks');
		}
    }
	else
	{
    		$error = "Book already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
