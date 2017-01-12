<?php
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['userEmail'], $_POST['password'])) 
{
	// User-supplied email
    $userEmail = $_POST['userEmail'];
	
	// User-supplied password, not hased until it hits the login function
    $password = $_POST['password']; 

    if (login($userEmail, $password) == true)
    {
        // Login success, check role ID to determine page to land at
			// Display Admin Dashboard
        	header('Location: ../pages/index');
    }
    else
    {
	$error = "Username/Password Fail"; 
        // Login failed, output a message via a $_SESSION variable
		header('Location: ../pages/error?error=' . $error);
    }
}
else
{
	$error = "Data not sent";
        // Login failed, output a message via a $_SESSION variable
	header('Location: ../pages/error?error=' . $error);
}
