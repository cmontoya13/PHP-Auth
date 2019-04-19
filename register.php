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
      $myemail = mysqli_real_escape_string($db,$_POST['email']);
      // md5 hash password with pre and post salt
      $preSalt = "%z|";
      $endSalt = "6*9!";
      $mypassword = md5($preSalt . $mypassword . $endSalt); // hash

      // query database and check whether 'username'/phone# already exists. If so return an error message. If not, continue on with code.
      $query = "SELECT id FROM admin WHERE username = '$myusername'";
      $result = mysqli_query($db, $query);
      $count = mysqli_num_rows($result);

      // If user is already in database
      if ($count > 0) {
         $msg = "That username already exists - try another.";         
      // User is not already in database
      } else {
         // create user in database
         $query2 = "INSERT INTO admin (username, passcode, email) VALUES ('$myusername', '$mypassword', '$myemail')";
         $result2 = mysqli_query($db, $query2);

         if ($result2) {
            $relayMsg = "Registration Successful - Please Log In";
            $_SESSION['message'] = $relayMsg; // open session to relay to another page
            header("Location: login.php");
         } else{
            $msg = "User Registration Failed";
         }
      }
      echo $msg;
      mysqli_close($db);
   }   
?>


<html>
   
   <head>
      <title>Registration Page</title>
      
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
         <div style="width:300px; border: solid 1px #333333; " align = "left">
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Register</b></div>
				
            <div style = "margin:30px">
               
               <form action="" method="post">
                  <label>UserName:  </label><input type="text" name="username" class="box"><br><br>
                  <label>Password:  </label><input type="password" name="password" class="box"><br><br>
                  <label>Email:  </label><input type="email" name="email" class="box"><br><br>                  
                  <input type="submit" value=" Submit "><br>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>