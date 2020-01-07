<!DOCTYPE html>
<html>
<head>
    <title>Securly Save your OpenSSL keypairs and share you digital certificate</title>
</head>
<body>
<h1>Securly Save your OpenSSL keypairs and share you digital certificate</h1>
    <p></p>
    <form name="login" action="keypairs.php" method="post" >
        <h1>Enter email to search for its ID</h1>
        <input type="email" name="email" placeholder="Email" required>
        <input type="submit" name='submit_btn'value="Submit  " />
    </form>
    </div>
</body>
</html>


<?php
if(isSet($_REQUEST["submit_btn"]))
    { 

require"conn.php";
$email=$_POST['email']; 
$query = "SELECT * FROM digitatl_certificate WHERE email='$email' ";
$result = mysqli_query($con,$query) or die(mysqli_error());
                $result=mysqli_query($con,$query);
                $rows = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                if($rows==1){
                    $user_id =$row['dc_id'];
                    echo"..................................";echo"<br>";
                    echo"..................................";echo"<br>";
                    echo"..................................";echo"<br>";
                    echo "Welcome  $email"; echo"<br>";
                    echo "Your ID is $user_id ";echo"<br>";
                    echo"You can share your ID to others so to acess and verify digiatl certificates";
                    echo"<br>";
                     echo"Please save your ID";echo"<br>";
                     echo"..................................";echo"<br>";
                     echo"..................................";echo"<br>";
                 // echo "<a href ='keypairs.php'>  </a>";
                
                }}
                ?>