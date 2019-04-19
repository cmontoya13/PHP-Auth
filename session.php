<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $query = "SELECT username FROM admin WHERE username = '$user_check'";
   $result = mysqli_query($db,$query);
   $row = mysqli_fetch_assoc($result);
   
   $login_session = $row['username'];
   
   if (!isset($_SESSION['login_user'])) {
      $relayMsg = "You must be logged in to enter the site.";
      $_SESSION['message'] = $relayMsg; // open session to relay message to another page
      header("location:login.php");
   }
?>