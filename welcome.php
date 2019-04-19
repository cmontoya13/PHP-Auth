<?php
   include('session.php');

   // Display message if one was relayed
   if (isset($_SESSION['message'])) {
      $relayMsg = $_SESSION['message'];
      unset($_SESSION['message']);
   }
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $login_session; ?></h1>

      <?php
         // relay messages passed from other pages
         if (isset($relayMsg)) {
            echo "<p>" . $relayMsg . "</p>";
         }
      ?>
      
      <a href="logout.php">Sign Out</a>
		<br>
		<br>
		<a href="change-password.php">Change Password</a>
		<br>
		<br>
		<a href="unsubscribe.php">Unsubscribe</a>
   </body>
   
</html>