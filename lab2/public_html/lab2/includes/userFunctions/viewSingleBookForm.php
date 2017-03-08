<?php

if (isset($_POST['bookISBN']))
{
	$_SESSION['bookISBN'] = $_POST['bookISBN'];
}

if (isset($_POST['changeBook']))
{
	unset($_SESSION['bookISBN']);
}


function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewSingleBookForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewSingleBookForm()
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

			if (!isset($_SESSION['bookISBN']))
			{
                                    singleBookForm();
			}
			else
			{
				viewSingleBookTable($_SESSION['bookISBN']);
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

function viewSingleBookTable($bookISBN)
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
                        getBooks($bookISBN);
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

function getBooks($bookISBN)
{
        $fileName = BOOKCSV;
    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {
                $ISBN = $newArray[$i][0];
                $Title = $newArray[$i][1];
                $Author = $newArray[$i][2];
                $Publisher = $newArray[$i][3];
                $Year = $newArray[$i][4];
                $publisherLink = $newArray[$i][5];
                $amazonLink = $newArray[$i][6];
                $courseUsed = $newArray[$i][7];
                if ($courseUsed==0)
                {
                        $courseUsed="CSCI";
                }
                else
                {
                        $courseUsed="MATH";
                }
                $numberInStock = $newArray[$i][8];
	
	if ($bookISBN == $ISBN)
	{
        	echo '
               	<tr class="gradeA">
                   <td>' . $ISBN . '</td>
                   <td>' . $Title . '</td>
                   <td>' . $Author . '</td>
                   <td>' . $Publisher . '</td>
                   <td>' . $Year . '</td>
                   <td>' . '<a href=" ' .  $publisherLink . '">Publisher Page</a>' .  '</td>
                 <td>' . '<a href=" ' .  $amazonLink . '">Amazon  Page</a>' .  '</td>
                   <td>' . $courseUsed . '</td>
                   <td>' . $numberInStock . '</td>
                  </tr>
             ';
	}
    }
}

function singleBookForm()
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("Book Title", "bookISBN");
			getBookList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "View Single Book");
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
