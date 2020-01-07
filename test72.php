<!doctype html>
<?php
 include("auth.php");
 include("conn.php"); 
 $email  = $_SESSION['email'] ;
 $data1=$_POST['message-cypher']; 
 $hash  = $_SESSION['hash'] ;

$sql = "UPDATE Files  SET digital_signature ='$data1',E_symKey ='$data1' WHERE hash= '$hash'";

   if ($con->query($sql))
   echo"success";
     
     else 
     echo"error";
     ?>
     <script type="text/javascript">
     window.location = "index.php";
     </script>   
 ?>
