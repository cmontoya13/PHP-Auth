<?php
	include("config.php");
	session_start();

	// Check for password reset expirations and clear from database
	$currentTime = time(); // in seconds since epoch

	$query = "SELECT * FROM admin WHERE forgottimeout IS NOT NULL AND forgottimeout <> ''"; // also checks for blanks
	$result = mysqli_query($db, $query);

	// Loop through each user with active password change fields
	while ($row = mysqli_fetch_array($result)) {
		$expiration = $row["forgottimeout"];
		$expiration = $expiration + 30; // expiration in seconds (86400 = 24hrs)
		$userid = $row["id"];

		if ($currentTime > $expiration) {
			mysqli_query($db, "UPDATE admin SET forgotpass = NULL, forgottimeout = NULL WHERE id = '$userid'");
		} else {
			// Not within the expiration period
		}
	}
	mysqli_close($db);
?>
<html">
   
   <head>
      <title>Home Page</title>
   </head>
   
   <body>
      <h1>Home Page</h1>

      <?php
         // relay messages passed from other pages
         if (isset($relayMsg)) {
            echo "<p>" . $relayMsg . "</p>";
         }
      ?>
      
      	<a href="Register.php">Sign Up</a>
		<br>
		<br>
		<a href="Login.php">Login</a>
   </body>
   
</html>