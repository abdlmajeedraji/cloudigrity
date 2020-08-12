<!doctype html>
<?php
include("auth.php");
include("conn.php");
$email  = $_SESSION['email'];
$data1 = $_POST['message-cypher'];
$hash  = $_SESSION['hash'];
//echo $hash;
//echo $data1;
//echo $email;

$query = "SELECT * FROM files WHERE hash='$hash' ";
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
  $file_id = $row['file_id'];
  // echo  $file_id;
  //  "UPDATE `files` SET `digital_signature` = '$data1', `E_symKey` = '$data1' WHERE `files`.`hash` = $hash";
  $sql =   "UPDATE `files` SET `digital_signature` = '" . $data1 . "', `E_symKey` ='" . $data1 . "' WHERE `files`.`file_id` = $file_id ";

  //$query = "UPDATE `users` SET `fname`='".$fname."',`lname`='".$lname."',`age`= $age WHERE `id` = $id";

  if ($con->query($sql)) {
    // echo "success";

  } else {
    echo ("Error description: " . mysqli_error($con));
  }
}


?>
<script type="text/javascript">
  window.location = "index.php";
</script>