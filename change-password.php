<?php
   include("config.php");
   session_start();

   // check if user is logged in
   if (isset($_SESSION['login_user'])) {   
      // If the values are posted, create variables and query the database
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $mypassword = mysqli_real_escape_string($db,$_POST['password']);
         // md5 hash password with pre and post salt
         $preSalt = "%z|";
         $endSalt = "6*9!";
         $mypassword = md5($preSalt . $mypassword . $endSalt); // hash

         // change the password in database for logged in user
         $query3 = "UPDATE admin SET passcode = '$mypassword' WHERE username = '$_SESSION[login_user]'";
         $result3 = mysqli_query($db, $query3);

         if ($result3) {
            $relayMsg = "Password change was successful.";
            $_SESSION['message'] = $relayMsg; // open session to relay to another page
            header("Location: welcome.php");
         } else {
            $msg = "Password Change Failed. " . mysqli_error($db);
         }
         echo $msg;
         mysqli_close($db);
      }
   } 


   elseif ($_GET['token']) {
      $urlToken = $_GET['token'];
      // query database and check for a url token match
      $query = "SELECT username FROM admin WHERE forgotpass = '$urlToken'";
      $result = mysqli_query($db, $query);
      $count = mysqli_num_rows($result);

      // If token exists create a user session
      if ($count == 1) {
         // get username from database and create a session
         $row = mysqli_fetch_assoc($result);
         $myusername = $row["username"];
         $_SESSION['login_user'] = $myusername;

         $query2 = "UPDATE admin SET forgotpass = NULL, forgottimeout = NULL WHERE forgotpass = '$urlToken'";
         $result2 = mysqli_query($db, $query2);
      } else {
         // not a valid token
      }



   } else {
      $relayMsg = "You must be logged in to change your password";
      $_SESSION['message'] = $relayMsg; // open session to relay to another page
      header("Location: login.php");
   }
   mysqli_close($db);
?>


<html>
   
   <head>
      <title>Change Password Page</title>
      
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
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Change Password</b></div>
				
            <div style = "margin:30px">
               
               <form action="" method="post">
                  <label>New Password:  </label><input type="password" name="password" class="box"><br><br>
                  <label>Confirm:  </label><input type="password" name="passconf" class="box"><br><br>
                  <input type="submit" value=" Submit "><br>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>