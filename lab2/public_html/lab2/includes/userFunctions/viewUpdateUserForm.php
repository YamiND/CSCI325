<?php

if (isset($_POST['modUserID']))
{
	$_SESSION['modUserID'] = $_POST['modUserID'];
}

if (isset($_POST['changeEmail']))
{
	unset($_SESSION['modUserID']);
}

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewUpdateUserForm($mysqli);
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewUpdateUserForm($mysqli)
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Modify User");
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
							if (!isset($_SESSION['modUserID']))
							{
                                    getUserForm($mysqli);
							}
							else
							{
								updateUserForm($_SESSION['modUserID'], $mysqli);

								echo "<br>";
				
								generateFormStart("", "post"); 
                                    generateFormButton("changeEmail", "Change User");
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

function updateUserForm($modUserID, $mysqli)
{
//TODO: FINISH THIS
	if ($stmt = $mysqli->prepare("SELECT userEmail, userFirstName, userLastName, userIsFaculty FROM users WHERE userID = ?"))
	{
		$stmt->bind_param('i', $modUserID);

		if ($stmt->execute())
		{
			$stmt->bind_result($userEmail, $userFirstName, $userLastName, $userIsFaculty);
			$stmt->store_result();

			while ($stmt->fetch())
			{
    			generateFormStart("../includes/userFunctions/updateUser", "post"); 
					generateFormHiddenInput("modUserID", $modUserID);
					generateFormInputDiv("Email", "email", "userEmail", $userEmail, NULL, NULL, NULL, "Email");
	        		generateFormInputDiv("First Name", "text", "userFirstName", $userFirstName, NULL, NULL, NULL, "First Name");
			        generateFormInputDiv("Last Name", "text", "userLastName", $userLastName, NULL, NULL, NULL, "Last Name");
			        generateFormInputDiv("New Password (if entered)", "password", "userPassword", NULL, NULL, NULL, NULL, "Password");
			        generateFormStartSelectDiv("User Role", "userRole");
						getRoleList($userIsFaculty);
			        generateFormEndSelectDiv();
   	    			generateFormButton(NULL, "Update User");
			    generateFormEnd();
			}
		}
	}
}

function getRoleList($selected)
{
	for ($i = 0; $i < 2; $i++)
	{
		if ($i == 0)
		{
			$roleName = "Student";
		}
		else
		{
			$roleName = "Faculty";
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

function getUserForm($mysqli)
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("User", "modUserID");
			getUserList($mysqli);
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Select User");
    generateFormEnd();
}

function getUserList($mysqli)
{
	if ($stmt = $mysqli->prepare("SELECT userID, userFirstName, userLastName FROM users"))
	{
		if ($stmt->execute())
		{
			$stmt->bind_result($userID, $userFirstName, $userLastName);
			
			while ($stmt->fetch())
			{
        		generateFormOption($userID, "$userLastName, $userFirstName");
			}
		}
	}
}

?>
