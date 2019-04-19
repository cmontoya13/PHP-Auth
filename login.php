<?php
   include("config.php");
   session_start();

   // Display message if one was relayed
   if (isset($_SESSION['message'])) {
      $relayMsg = $_SESSION['message'];
      unset($_SESSION['message']);
   }
   
   // If the values are posted, create variables and query the database
   if ($_SERVER["REQUEST_METHOD"] == "POST") {      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
      // md5 hash password with pre and post salt
      $preSalt = "%z|";
      $endSalt = "6*9!";
      $mypassword = md5($preSalt . $mypassword . $endSalt); // hash
      
      // select the user match
      $query = "SELECT id FROM admin WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$query);
      
      // check if username exists
      $count = mysqli_num_rows($result);
      
      // If result matched, $count will equal '1' or true
      if ($count == 1) {
         // create a session with username
         $_SESSION['login_user'] = $myusername;
         header("location: welcome.php");
      } else {
         $msg = "Your Login Name and/or Password is invalid";
      }
      echo $msg;
      mysqli_close($db);
   }
?>


<html>
   
   <head>
      <title>Login Page</title>
      
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
      <?php
         // relay messages passed from other pages
         if (isset($relayMsg)) {
            echo "<p>" . $relayMsg . "</p>";
         }
      ?>
      <div align="center">
         <div style="width:300px; border: solid 1px #333333; " align="left">
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style="margin:30px">
               
               <form action="" method="post">
                  <label>UserName:  </label><input type="text" name="username" class="box"><br><br>
                  <label>Password:  </label><input type="password" name="password" class="box"><br><br>
                  <a href="forgot-password.php">Forgot My Password</a><br><br>
                  <input type="submit" value=" Submit "><br>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>