<?php

if (isset($_POST['updateEmail']))
{
	$_SESSION['updateEmail'] = $_POST['updateEmail'];
}

if (isset($_POST['changeEmail']))
{
	unset($_SESSION['updateEmail']);
}

function checkPermissions()
{
    if (login_check() == true)
    {
        viewUpdateUserForm();

    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewUpdateUserForm()
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
							if (!isset($_SESSION['updateEmail']))
							{
                                    getUserForm();
							}
							else
							{
								updateUserForm($_SESSION['updateEmail']);

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

function updateUserForm($userEmail)
{
	unset($_SESSION['updateEmail']);

	$fileName = USERCSV;

    $newArray = array_map('str_getcsv', file($fileName));

    for ($i = 0; $i < count($newArray); $i++)
    {   
        if ($newArray[$i][3] == $userEmail) 
        {   
			$userFirstName = $newArray[$i][0];
			$userLastName = $newArray[$i][1];
			$userName = $newArray[$i][2];
			$userRole = $newArray[$i][5];
    		generateFormStart("../includes/userFunctions/updateUser", "post"); 
				generateFormHiddenInput("oldEmail", $userEmail);
				generateFormInputDiv("Email", "email", "userEmail", $userEmail, NULL, NULL, NULL, "Email");
       		    generateFormInputDiv("Username", "text", "userName", $userName, NULL, NULL, NULL, "Username");
        		generateFormInputDiv("First Name", "text", "userFirstName", $userFirstName, NULL, NULL, NULL, "First Name");
		        generateFormInputDiv("Last Name", "text", "userLastName", $userLastName, NULL, NULL, NULL, "Last Name");
		        generateFormInputDiv("New Password (if entered)", "password", "userPassword", NULL, NULL, NULL, NULL, "Password");
		        generateFormStartSelectDiv("User Role", "userRole");
					getRoleList($userRole);
		        generateFormEndSelectDiv();
       			generateFormButton(NULL, "Update User");
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
			$roleName = "Faculty";
		}
		else
		{
			$roleName = "Student";
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

function getUserForm()
{
    generateFormStart("", "post"); 
        generateFormStartSelectDiv("User's Email", "updateEmail");
			getUserList();
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Select User");
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
