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
		
		//go through posts
		foreach($_POST as $key => $value)
		{
			//check for null
			if (!empty($value))
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
			else
			{
				//set session variable and redirect to add course
				$_SESSION['fail'] = 'I can\'t process html characters, slashes, spaces at the end, or null values. Try fixing your input.';
				header('Location: ../../pages/updatebooks');
			}
		}
		
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
