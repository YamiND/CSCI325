<?php
include_once '../dbConnect.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.

if (login_check($mysqli) == true) 
{
	updateBook($mysqli);
}
else
{
   	$_SESSION['fail'] = 'Course modification Failed, invalid permissions';
//   	header('Location: ../../pages/adduser');

	return;
}

function updateBook($mysqli)
{
	if (isset($_POST['bookISBN'], $_POST['bookTitle'], $_POST['bookAuthor'], $_POST['bookPublisher'], $_POST['bookYear'], $_POST['bookPublisherLink'], $_POST['bookAmazonLink'], $_POST['bookCourseType'], $_POST['bookStock'], $_POST['bookID'])) 
	{
		$bookID = $_POST['bookID'];
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
			$bookCourse = "CSCI";
		}
		else
		{
			$bookCourse = "MATH";
		}

		if ($stmt = $mysqli->prepare("UPDATE books set bookISBN = ?, bookName = ?, bookAuthor = ?, bookPublisher = ?, bookPublisherLink = ?, bookAmazonLink = ?, bookCourse = ?, bookStock = ?, bookYear = ? WHERE bookID = ?"))
		{

			$stmt->bind_param('sssssssisi', $bookISBN, $bookName, $bookAuthor, $bookPublisher, $bookPublisherLink, $bookAmazonLink, $bookCourse, $bookStock, $bookYear, $bookID);

			if ($stmt->execute())
			{
				$_SESSION['success'] = "Book updated";
		   		header('Location: ../../pages/updatebooks');
			}
			else
			{
    			$error = "Book could not be updated";
		   	   	header('Location: ../../pages/error?error=' . $error);
			}
		}
    }
	else
	{
    	$error = "Book could not be updated, data not sent";
	    header('Location: ../../pages/error?error=' . $error);
	}
}

?>
