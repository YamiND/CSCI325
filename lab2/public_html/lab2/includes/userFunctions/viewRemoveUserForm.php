<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewRemoveUserForm($mysqli);

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewRemoveUserForm($mysqli)
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
                                    removeUserForm($mysqli);
                                    
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

function removeUserForm($mysqli)
{
    	generateFormStart("../includes/userFunctions/removeUser", "post"); 
        generateFormStartSelectDiv("User's Name", "userID");
	getUserList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Remove User");
        generateFormEnd();

}

function getUserList($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT userFirstName, userLastName, userID FROM users"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($userFirstName, $userLastName, $userID);
			$stmt->store_result();

			while ($stmt->fetch())
			{
	        	generateFormOption($userID, "$userLastName, $userFirstName");
			}
		}
	}
}

?>
