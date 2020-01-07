<?php
if(isSet($_REQUEST["submit_btn"]))
    { 
    require"conn.php";
//	$con=connect();
    $title=$_POST['name']; 
    $email=$_POST['email']; 
    $advert=$_POST['issuer'];
    $date1=$_POST['ValidFrom']; 
    $date2=$_POST['ValidTill']; 
    $date =  date('y/m/d');    
    //public key
		$img_name=$_FILES['file']['name'];
		$img_size=$_FILES['file']['size'];
        $img_tmp=$_FILES['file']['tmp_name'];

        $directory='uploads';
        $directory1=$directory."/".$email."/";
        if(!is_dir($directory1)) {
            mkdir($directory1);
        } 
		$target_file=$directory1.$img_name;
        move_uploaded_file($img_tmp,$target_file);
//private  key
        $img_name1=$_FILES['file1']['name'];
		$img_size1=$_FILES['file1']['size'];
        $img_tmp1=$_FILES['file1']['tmp_name'];
        $directory1='uploads';
        $directory1=$directory."/".$email."/";
        if(!is_dir($directory1)) {
            mkdir($directory1);
        } 
		$target_file1=$directory1.$img_name1;
        move_uploaded_file($img_tmp1,$target_file1);
        
$query="insert into `digitatl_certificate`( `person_identified`,`Issuer`,
`Valid_From`, `Valid_To`,
`private_key`,`public_key`,`email`)

values('".$title."','".$advert."','".$date1."','".$date2."','".$target_file1."',
'".$target_file."','".$email."')";  
$query_run = mysqli_query($con,$query) ;
        
if($query_run){
    echo ("<script> alert('Added sucesfully!') </script>"); 
			 //  echo("<script> window.location='login.php'; </script>");
                }
                else{
                    die ("couldn't add advertiisment   ".$con->error);
                     }   
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
                     echo" Click  <a href ='keypairs.php'>here</a> to search for an ID ";echo"<br>";
                 // echo "<a href ='keypairs.php'>  </a>";
                
                }
		       
				
		    

		}
	//$conn->close();
	
?>

