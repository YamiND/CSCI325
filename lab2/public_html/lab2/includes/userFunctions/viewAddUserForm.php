<?php

function checkPermissions($mysqli)
{
    if (login_check($mysqli) == true)
    {
        viewCreateUserForm();
    }
    else
    {
        $_SESSION['fail'] = 'Invalid Access, you do not have permission';
        // Call Session Message code and Panel Heading here
        displayPanelHeading();
    }
}


function viewCreateUserForm()
{
    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
	';
						displayPanelHeading("Create User");
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
                                    createUserForm();
                                    
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

function createUserForm()
{
    	generateFormStart("../includes/userFunctions/createUser", "post"); 
        generateFormInputDiv("Email", "email", "userEmail", NULL, NULL, NULL, NULL, "Email");
        generateFormInputDiv("UserName", "text", "userName", NULL, NULL, NULL, NULL, "Username");
        generateFormInputDiv("First Name", "text", "userFirstName", NULL, NULL, NULL, NULL, "First Name");
        generateFormInputDiv("Last Name", "text", "userLastName", NULL, NULL, NULL, NULL, "Last Name");
	generateFormInputDiv("Password", "password", "userPassword", NULL, NULL, NULL, NULL, "Password");
        generateFormStartSelectDiv("User Role", "userRole");
        generateFormOption("1", "Faculty");
        generateFormOption("0", "Student");
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Create User");
        generateFormEnd();
}

?>
