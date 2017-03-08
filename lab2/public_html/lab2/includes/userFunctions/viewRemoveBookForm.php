<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewRemoveBookForm($mysqli);

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveBookForm($mysqli)
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Remove Book");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">Remove Book</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    removeBookForm($mysqli);
                                    
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

function removeBookForm($mysqli)
{
    generateFormStart("../includes/userFunctions/removeBook", "post"); 
        generateFormStartSelectDiv("Book Title", "bookID");
			getBookList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove Book");
    generateFormEnd();
}

function getBookList($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT bookID, bookName FROM books"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($bookID, $bookName);
			$stmt->store_result();
	
			while ($stmt->fetch())
			{	
	        	generateFormOption($bookID, $bookName);
			}
		}
	}
}

?>
