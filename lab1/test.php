<?php
	$line2=array();
	
	if (($file = fopen("test.csv", "r")) !== FALSE) 
	{
		while (($line = fgetcsv($file)) !== FALSE) 
		{
			$line2=array_chunk($line, 6);
		}
		fclose($file);
	}
	
	function searchUser($email, $password, $line2)
	{
		for ($i=0; $i<count($line2); $i++)
		{	
			if ($line2[$i][3]==$email && $line2[$i][4]==$password)
			{

				echo $line2[$i][5] . "<br>";
				echo "User found! <br>";
				return;
			}
		}
		
//		echo "Email and password not found.";
	}
	
	function hardCodeUser($line2)
	{
		$email="bjones@blah.com";
		$password="90";
		
		for ($i=0; $i<count($line2); $i++)
		{	
			if ($line2[$i][3]==$email && $line2[$i][4]==$password)
			{
				echo "User found! <br>";

				echo $line2[$i][3];
				return;
			}
		}
		
		echo "Email and password not found.";
	}
	
//	searchUser("shead@blah.com", "5678", $line2);
	hardCodeUser($line2);
?>
