<?php
   include("config.php");
   session_start();
   
   // check if user is logged in else give login message
   if (isset($_SESSION['login_user'])) {
      // If the values are posted, create variables and query the database
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

         $unsub = mysqli_real_escape_string($db,$_POST['unsubscribe']);

         if ($unsub == "yes") {
            $query = "DELETE FROM admin WHERE username = '$_SESSION[login_user]'";
            $result = mysqli_query($db,$query);

            if ($result) {
               unset($_SESSION['login_user']);
               $relayMsg = "Unsubscribe was successful.";
               $_SESSION['message'] = $relayMsg; // open session to relay message to another page           
               header("Location: register.php");
            } else {
               $msg = "Error deleting record";
            }
         } else { // answer was 'no'
            $relayMsg = "Great to see you changed your mind.";
            $_SESSION['message'] = $relayMsg; // open session to relay message to another page
            header('location: welcome.php');
         }
         echo $msg;
         mysqli_close($db);
      }
   } else {
      $relayMsg = "You must be logged in to unsubscribe.";
      $_SESSION['message'] = $relayMsg; // open session to relay message to another page
      header('location: login.php');
   }
?>


<html>
   
   <head>
      <title>Unsubscribe Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor="#FFFFFF">
	
      <div align="center">
         <div style="width:300px; border: solid 1px #333333; " align = "left">
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Unsubscribe</b></div>
				
            <div style = "margin:30px">
               
               <form action="" method="post">
                  <label>Are you sure you want to unsubscribe? </label><br>
                  <input type="radio" name="unsubscribe" value="yes"> Yes<br>
                  <input type="radio" name="unsubscribe" value="no"> No<br><br>
                  <input type="submit" value=" Submit "><br>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>