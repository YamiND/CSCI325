<?php
include_once '../dbConnect.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	addBook($mysqli);
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

function addBook($mysqli)
{
	if (isset($_POST['bookISBN'], $_POST['bookTitle'], $_POST['bookAuthor'], $_POST['bookPublisher'], $_POST['bookYear'], $_POST['bookPublisherLink'], $_POST['bookAmazonLink'], $_POST['bookCourseType'], $_POST['bookStock'])) 
	{
		
   		$bookISBN = $_POST['bookISBN'];
		$bookName = $_POST['bookTitle'];
		$bookAuthor = $_POST['bookAuthor'];
		$bookPublisher = $_POST['bookPublisher'];
		$bookYear = $_POST['bookYear'];
		$bookPublisherLink = $_POST['bookPublisherLink'];
		$bookAmazonLink = $_POST['bookAmazonLink'];
		$bookCourseType = $_POST['bookCourseType'];
		$bookStock = $_POST['bookStock'];

		if ($bookCourseType == "0")
		{
			$bookCourseType = "CSCI";
		}
		else
		{
			$bookCourseType = "MATH";
		}

		if ($stmt = $mysqli->prepare("INSERT INTO books (bookISBN, bookName, bookAuthor, bookPublisher, bookPublisherLink, bookAmazonLink, bookCourse, bookStock, bookYear) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"))
		{
			$stmt->bind_param('sssssssis', $bookISBN, $bookName, $bookAuthor, $bookPublisher, $bookPublisherLink, $bookAmazonLink, $bookCourseType, $bookStock, $bookYear);
			
			if ($stmt->execute())
			{
				$_SESSION['success'] = "Book Added";
		                header('Location: ../../pages/addbooks');
			}
			else
			{
//    				$error = "Book could not be inserted"; 
				$error = $stmt->error;
		   	   	header('Location: ../../pages/error?error=' . $error);

			}
		}

	}
	else
	{
    		$error = "Book already exists"; 
	   	   	header('Location: ../../pages/error?error=' . $error);
	}
}

?>
