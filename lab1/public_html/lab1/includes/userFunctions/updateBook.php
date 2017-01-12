<?php
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check() == true) 
{
	updateBook();
}
else
{
	echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

   	$_SESSION['fail'] = 'Course modification Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function updateBook()
{
	if (isset($_POST['bookISBN'], $_POST['bookTitle'], $_POST['bookAuthor'], $_POST['bookPublisher'], $_POST['bookYear'], $_POST['bookPublisherLink'], $_POST['bookAmazonLink'], $_POST['bookCourseType'], $_POST['bookStock'], $_POST['oldBookISBN'])) 
	{
		$oldBookISBN = $_POST['oldBookISBN'];
		$bookISBN = $_POST['bookISBN'];
		$bookTitle = $_POST['bookTitle'];
    	$bookAuthor = $_POST['bookAuthor'];
		$bookPublisher = $_POST['bookPublisher'];
		$bookYear = $_POST['bookYear'];
		$bookPublisherLink = $_POST['bookPublisherLink'];
		$bookAmazonLink = $_POST['bookAmazonLink'];
		$bookCourseType = $_POST['bookCourseType'];
		$bookStock = $_POST['bookStock'];


		$fileName = BOOKCSV;
        $newArray = array_map('str_getcsv', file($fileName));

        $success = false;

        for ($i = 0; $i < count($newArray); $i++)
        {   
            if ($newArray[$i][0] == $oldBookISBN) 
            {   
                    $success = true;
                    break;
            }   
        }    

        if (($success) && ($oldBookISBN != $bookISBN))
        {   
            $error = "Book already exists, can't change"; 
            header('Location: ../../pages/error?error=' . $error);
			return;
        }
		else
		{
 	       	for ($i = 0; $i < count($newArray); $i++)
			{  
            	if ($newArray[$i][0] == $bookISBN) 
            	{   
                	removeLine(BOOKCSV, $bookISBN);
            	}   
        	}  
		}

		$handle = fopen($fileName, "a");
		fputcsv($handle, array($bookISBN, $bookTitle, $bookAuthor, $bookPublisher, $bookYear, $bookPublisherLink, $bookAmazonLink, $bookCourseType, $bookStock));
		fclose($handle);
		$_SESSION['success'] = "Book updated";
   		header('Location: ../../pages/updatebooks');
    }
	else
	{
    		$error = "Book already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
