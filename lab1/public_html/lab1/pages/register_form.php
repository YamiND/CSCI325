<?php
include_once '../includes/functions.php';
include_once '../includes/formTemplate.php';

//sec_session_start();

if (!isset($_POST['passcode'])):

?>
<html lang="en">

<head>
    <title>Register User</title>

    <!-- Header Information, CSS, and JS -->
    <?php include("../includes/header.php"); ?>
</head>

<body>
<!-- displaySite("Register User"); -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<h3 class="panel-title">Enter Passcode to Register</h3>
                    </div>
                    <div class="panel-body">
                        <!--<form role="form">-->
						<form action="" method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Passcode" name="passcode" type="password" value="">
                                </div>
				
				<input type="Submit" class="btn btn-lg btn-success btn-block" 
                                                   value="Sign in" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php

else:

$code = $_POST['passcode'];

if ($code == "1337")
{
	viewRegisterUserForm($code);

}
else
{
    header('Location: ../pages/register_form'); 
}


endif;


function viewRegisterUserForm($code)
{
 echo '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title>Register User</title>
            <!-- Header Information, CSS, and JS -->
            ';

            include("../includes/header.php");
    echo '
        </head>

        <body>

            <div id="wrapper">

        	<!-- Navigation Menu -->
        ';
    echo '
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Register User</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
            ';


    echo '
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<h4>Create User</h4>
	';

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
                                    createUserForm($code);
                                    
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

echo '
                </div>
                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->

        </body>

        </html>
    ';

}

function createUserForm($code)
{
    	generateFormStart("../includes/userFunctions/createUser", "post"); 
		generateFormHiddenInput("code", $code);
        generateFormInputDiv("Email", "email", "userEmail", NULL, NULL, NULL, NULL, "Email");
        generateFormInputDiv("UserName", "text", "userName", NULL, NULL, NULL, NULL, "Username");
        generateFormInputDiv("First Name", "text", "userFirstName", NULL, NULL, NULL, NULL, "First Name");
        generateFormInputDiv("Last Name", "text", "userLastName", NULL, NULL, NULL, NULL, "Last Name");
	generateFormInputDiv("Password", "password", "userPassword", NULL, NULL, NULL, NULL, "Password");
        generateFormStartSelectDiv("User Role", "userRole");
        generateFormOption("0", "Faculty");
        generateFormOption("1", "Student");
        generateFormEndSelectDiv();
        generateFormButton(NULL, "Create User");
        generateFormEnd();
}

?>
