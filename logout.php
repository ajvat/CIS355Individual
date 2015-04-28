<?php	
// filename: logout.php, Anthony Vatter, cis355, 2015-04-26
// sets the $_SESSION email variable to "" to log out the user

	session_start();
	
        $_SESSION["email"] = "";
	
	header('Location: index.php');

?>