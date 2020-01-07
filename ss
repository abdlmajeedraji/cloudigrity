<?php
$from_ = $_POST['org'];
$name = $_POST['fname'];
$telephone = $_POST['phone'];
$ttime = $_POST['time'];
$dday = $_POST['day'];
$mmonthh = $_POST['month'];
$yyear = $_POST['year'];
$type=  $_POST['type'];

$sdate = ("$yyear-$mmonthh-$dday");

$user = "root";
$pass = "";
$host= "localhost";
$dbname="al_nuba";
 
$con = mysqli_connect($host,$user,$pass,$dbname);
$query="select * from users WHERE telephone='$telephone'";
		 $query_run=mysqli_query($con,$query);
		 
		 $rows = mysqli_num_rows($query_run);
		 $row = mysqli_fetch_assoc($query_run);
		   if( mysqli_num_rows($query_run) > 0)
			{
				$c_id =$row['id']; 
				echo $c_id;
				$sql="insert into booking(c_id,time,type,date,from_) values('".$c_id."','".$ttime."','".$type."','".$sdate."','".$from_."');";	
		}			
			else {
            $sql="insert into users(name,telephone,from_) values('".$name."','".$telephone."','".$from_."');";
			 
			 $query_run=mysqli_query($con,$sql);
			 if($query_run)
			    {

				}
			 else
				{ 
				  die("Unable to add data:".$con->error);
				  echo ("<script> alert(' failed'+.$con->error) </script>");
				  echo '<script type="text/javascript"> alert("registration failed"+$con->error) </script>';
			        
			    } }
			
        $con->close();		

?>