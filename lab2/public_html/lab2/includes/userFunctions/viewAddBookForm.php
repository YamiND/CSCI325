<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewAddBookForm();
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewAddBookForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Add Book");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Add Book</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    addBookForm();
                                    
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

function addBookForm()
{
    generateFormStart("../includes/userFunctions/addBook", "post"); 
        generateFormInputDiv("ISBN", "number", "bookISBN", NULL, NULL, NULL, NULL, "ISBN");
        generateFormInputDiv("Title", "text", "bookTitle", NULL, NULL, NULL, NULL, "Title");
        generateFormInputDiv("Author", "text", "bookAuthor", NULL, NULL, NULL, NULL, "Author");
        generateFormInputDiv("Publisher", "text", "bookPublisher", NULL, NULL, NULL, NULL, "Publisher");
        generateFormInputDiv("Year Published", "number", "bookYear", date('Y'), NULL, NULL, NULL, "Year Published");
        generateFormInputDiv("Link to Publisher Site", "text", "bookPublisherLink", NULL, NULL, NULL, NULL, "Link to Publisher Site");
        generateFormInputDiv("Link to Book on Amazon", "text", "bookAmazonLink", NULL, NULL, NULL, NULL, "Link to Book on Amazon");
		generateFormStartSelectDiv("Course Type", "bookCourseType");
        generateFormOption("0", "CSCI");
        generateFormOption("1", "Math");
        generateFormEndSelectDiv();
        generateFormInputDiv("Number in Stock", "number", "bookStock", 0, NULL, NULL, "Number in Stock");
        generateFormButton(NULL, "Add Book");
   generateFormEnd();
}

?>
