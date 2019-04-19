<?php
   include("config.php");
   session_start();
   
   // If the values are posted, create variables and query the database
   if ($_SERVER["REQUEST_METHOD"] == "POST") {     
      $myusername = mysqli_real_escape_string($db,$_POST['username']);

      $query = "SELECT email FROM admin WHERE username = '$myusername'";
      $result = mysqli_query($db,$query);
      $row = mysqli_fetch_assoc($result);
      $email = $row["email"];      
      $count = mysqli_num_rows($result); // check if username exists
            
      // If result matched, $count will equal '1'
      if ($count == 1) {
         // create a db5 salt for passcode change verification
         $t = time();
         $dateTime = date("Y-m-d" . $t); // capture date-timestamp
         $addSalt = ")<l4"; // salt for additional security
         $eToken = md5($dateTime . $addSalt . $myusername); // hash

         // add security token to 'forgotpass' in database for this user
         $query2 = "UPDATE admin SET forgotpass = '$eToken', forgottimeout = '$t' WHERE username = '$myusername'";
         $result2 = mysqli_query($db, $query2);

         // Send email
         $to = $email;
         $subject = "Email Subject"; // customize the email Subject
         $txt = "Click this link to reset your password: <https:www.yourURL.com/change-password.php?token=" . $eToken . ">";
         $headers = "From: Password Reset <mailbox@yourURL.com> \r\n"; // customize with your email server settings
         mail($to,$subject,$txt,$headers);         
      }
      echo "Password reset instructions have been emailed to the address on file.";
      mysqli_close($db);
   }
?>


<html>
   
   <head>
      <title>Forgot Password Page</title>
      
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
            <div style="background-color:#333333; color:#FFFFFF; padding:3px;"><b>Forgot Password</b></div>
				
            <div style = "margin:30px">
               
               <form action="" method="post">
                  <label>UserName:  </label><input type="text" name="username" class="box"><br><br>                 
                  <input type="submit" value=" Submit "><br>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>