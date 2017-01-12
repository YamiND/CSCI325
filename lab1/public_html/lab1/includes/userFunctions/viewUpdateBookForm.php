<?php

if (isset($_POST['updateBook']))
{
	$_SESSION['updateBook'] = $_POST['updateBook'];
}

if (isset($_POST['changeBook']))
{
	unset($_SESSION['updateBook']);
}

function checkPermissions()
{
    if (login_check() == true)
    {
        viewUpdateBookForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewUpdateBookForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Update Book");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Update Book</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
							if (!isset($_SESSION['updateBook']))
							{
                                    getBookForm();
							}
							else
							{
								updateBookForm($_SESSION['updateBook']);

								echo "<br>";
				
								generateFormStart("", "post"); 
                                    generateFormButton("changeBook", "Change Book");
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

function updateBookForm($bookISBN)
{
	unset($_SESSION['updateBook']);

	$fileName = BOOKCSV;

    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {   
        if ($newArray[$i][0] == $bookISBN) 
        {   
	        
	        $bookISBN = $newArray[$i][0];
	        $bookTitle = $newArray[$i][1];
	        $bookAuthor = $newArray[$i][2];
	        $bookPublisher = $newArray[$i][3];
	        $bookYear = $newArray[$i][4];
	        $bookPublisherLink = $newArray[$i][5];
	        $bookAmazonLink = $newArray[$i][6];
	        $bookCourse = $newArray[$i][7];
	        $bookStock = $newArray[$i][8];
			
    		generateFormStart("../includes/userFunctions/updateBook", "post"); 
			    generateFormInputDiv("ISBN", "number", "bookISBN", $bookISBN, NULL, NULL, NULL, "ISBN");
				generateFormInputDiv("Title", "text", "bookTitle", $bookTitle, NULL, NULL, NULL, "Title");
				generateFormInputDiv("Author", "text", "bookAuthor", $bookAuthor, NULL, NULL, NULL, "Author");
				generateFormInputDiv("Publisher", "text", "bookPublisher", $bookPublisher, NULL, NULL, NULL, "Publisher");
				generateFormInputDiv("Year Published", "number", "bookYear", $bookYear, NULL, NULL, NULL, "Year Published");
				generateFormInputDiv("Link to Publisher Site", "text", "bookPublisherLink", $bookPublisherLink, NULL, NULL, NULL, "Link to Publisher Site");
				generateFormInputDiv("Link to Book on Amazon", "text", "bookAmazonLink", $bookAmazonLink, NULL, NULL, NULL, "Link to Book on Amazon");
				generateFormStartSelectDiv("Course Type", "bookCourseType");
				getRoleList($bookCourse);
				generateFormEndSelectDiv();
				generateFormInputDiv("Number in Stock", "number", "bookStock", $bookStock, NULL, NULL, "Number in Stock");
				generateFormButton(NULL, "Update Book");
			 generateFormEnd();
        }   
    }    
}

function getRoleList($selected)
{

	for ($i = 0; $i < 2; $i++)
	{
		if ($i == 0)
		{
			$roleName = "CSCI";
		}
		else
		{
			$roleName = "MATH";
		}
		if ($i == $selected)
		{
            generateFormOption($selected, $roleName, NULL, "selected");
		}
		else
		{
            generateFormOption($i, $roleName);
		}
	}
}	


function getBookForm()
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("Book Title", "updateBook");
			getBookList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Select Book");
    generateFormEnd();
}

function getBookList()
{
	$fileName = BOOKCSV;

    $newArray = array_map('str_getcsv', file($fileName));

	for ($i = 0; $i < count($newArray); $i++)
    {
        generateFormOption($newArray[$i][0], $newArray[$i][1]);
	}
}

?>