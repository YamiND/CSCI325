<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewRemoveUserForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveUserForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Remove User");
echo '
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#administrator" data-toggle="tab">User</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="administrator">
                                    <br>
            ';
                                    removeUserForm();
                                    
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

function removeUserForm()
{
    	generateFormStart("../includes/userFunctions/removeUser", "post"); 
        generateFormStartSelectDiv("User's Email", "userEmail");
	getUserList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove User");
        generateFormEnd();

}

function getUserList()
{
	$fileName = USERCSV;

    $newArray = array_map('str_getcsv', file($fileName));

	for ($i = 0; $i < count($newArray); $i++)
    {
        generateFormOption($newArray[$i][3], $newArray[$i][3]);
	}
}

?>
