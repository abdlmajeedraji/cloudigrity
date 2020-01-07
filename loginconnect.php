<script type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<?php
include("conn.php");
session_start();
$mypassword=$_GET['password'];
$myemail=$_GET['email'];
      // username and password sent from form 
   //	$myemail = stripslashes($_POST['email']); // removes backslashes
		$myemail = mysqli_real_escape_string($con,$myemail); //escapes special characters in a string
		//$mypassword = stripslashes($_POST['password']);
      $mypassword = mysqli_real_escape_string($con,$mypassword);
      $mypassword = md5($mypassword);
      
	//Checking is user existing in the database or not
   $query = "SELECT * FROM users WHERE email='$myemail' and password='$mypassword'";
   $result = mysqli_query($con,$query) or die(mysqli_error());
   $rows = mysqli_num_rows($result);
   $row = mysqli_fetch_assoc($result);
     if($rows==1){
            $user_id =$row['user_id'];
      $sql = "INSERT INTO Users_Audit(user_id,email) values ('$user_id','$myemail')"; /*inserts into table 'login' of database 'phothub' */
      $result = mysqli_query($con,$sql) or die(mysqli_error());
      $_SESSION['email'] = $myemail;
      $_SESSION['fname'] = $fname;
      header("Location: index.php"); // Redirect user to home.html
         }
         else{ 
           ?>
            <script>
            alert('Incorrect details');
            location ="login.html";
            </script>
               <?php

     
      }

   
  
?>