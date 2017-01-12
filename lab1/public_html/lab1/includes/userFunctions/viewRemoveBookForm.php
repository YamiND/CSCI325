<?php

function checkPermissions()
{
    if (login_check() == true)
    {
        viewRemoveBookForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveBookForm()
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
                                    removeBookForm();
                                    
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

function removeBookForm()
{
    generateFormStart("../includes/userFunctions/removeBook", "post"); 
        generateFormStartSelectDiv("Book Title", "bookTitle");
			getBookList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove Book");
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
