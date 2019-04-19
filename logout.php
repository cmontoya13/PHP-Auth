<?php
   	session_start();
   
   	unset($_SESSION['login_user']);
	$relayMsg = "You have successfully logged out";
	$_SESSION['message'] = $relayMsg; // open session to relay messsage to another page	
	header("Location: index.php");
?>