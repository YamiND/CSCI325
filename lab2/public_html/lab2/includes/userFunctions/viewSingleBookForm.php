<?php

if (isset($_POST['bookID']))
{
	$_SESSION['bookID'] = $_POST['bookID'];
}

if (isset($_POST['changeBook']))
{
	unset($_SESSION['bookID']);
}


function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewSingleBookForm($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewSingleBookForm($mysqli)
{
    echo '
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("View Single Book");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">View Single Book</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';

			if (!isset($_SESSION['bookID']))
			{
                                    singleBookForm($mysqli);
			}
			else
			{
				viewSingleBookTable($_SESSION['bookID'], $mysqli);
				echo "<br>";
    				generateFormStart("", "post"); 
        				generateFormButton("changeBook", "Choose another Book");
				 generateFormEnd();
			}
                                    
        echo '
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
';

}

function viewSingleBookTable($bookID, $mysqli)
{
    $userTable = "profile";
    echo '
                <!-- DataTables CSS -->
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <!-- DataTables Responsive CSS -->
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!-- DataTables JavaScript -->
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

                        <table width="100%" class="table table-striped table-bordered table-hover" id="' . $userTable . '">
                <thead>
                        <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Publisher Page</th>
                        <th>Amazon Link</th>
                        <th>Course Used</th>
                        <th>Number In Stock</th>
                    </tr>
                </thead>
            <tbody>
        ';
                        getBooks($bookID, $mysqli);
    echo '
                </tbody>
          </table>
                                <!-- /.table-responsive -->

                <!-- Page-Level Demo Scripts - Tables - Use for reference -->
                <script>
                $(document).ready(function() {
                    $(\'#' . $userTable . '\').DataTable({
                        responsive: true
                    });
                });
                </script>
        ';

}

function getBooks($bookID, $mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT courseID FROM bookCourseIDs WHERE bookID = ? LIMIT 1"))
	{
		// Yeah for now a book can only be used in 1 class....
		$stmt->bind_param('i', $bookID); 

		if ($stmt->execute())
		{
			$stmt->bind_result($courseID);
			$stmt->store_result();

			while ($stmt->fetch())
			{
				$courseName = getCourseName($courseID, $mysqli);
			}
		}
		else
		{
			$courseName = "Not used in course";
		}
	}
	else
	{
		$courseName = "Not used in course";
	}


	if (empty($courseName))
	{
		$courseName = "N/A";
	}

	if ($stmt = $mysqli->prepare("SELECT bookISBN, bookName, bookAuthor, bookPublisher, bookPublisherLink, bookAmazonLink, bookCourse, bookStock, bookYear FROM books WHERE bookID = ?"))
	{
		$stmt->bind_param('i', $bookID);
	
		if ($stmt->execute())
		{	
			$stmt->bind_result($bookISBN, $bookName, $bookAuthor, $bookPublisher, $bookPublisherLink, $bookAmazonLink, $bookCourse, $bookStock, $bookYear);

			while ($stmt->fetch())
			{
        		echo '
               		<tr class="gradeA">
               		    <td>' . $bookISBN . '</td>
               		    <td>' . $bookName . '</td>
	                   <td>' . $bookAuthor . '</td>
   		                <td>' . $bookPublisher . '</td>
       		            <td>' . $bookYear . '</td>
           		        <td>' . '<a href=" ' .  $bookPublisherLink . '">Publisher Page</a>' .  '</td>
               		  <td>' . '<a href=" ' .  $bookAmazonLink . '">Amazon  Page</a>' .  '</td>
                   		<td>' . $courseName . '</td>
	                   <td>' . $bookStock . '</td>
                  </tr>
  		           ';
			}
		}
    }
}

function singleBookForm($mysqli)
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("Book Title", "bookID");
			getBookList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "View Single Book");
    generateFormEnd();
}

function getBookList($mysqli)
{

	if ($stmt = $mysqli->prepare("SELECT bookID, bookName FROM books"))
    {
		if ($stmt->execute())
		{
			$stmt->bind_result($bookID, $bookName);

			while ($stmt->fetch())
			{
        		generateFormOption($bookID, $bookName);
			}
		}
	}
}

?>
