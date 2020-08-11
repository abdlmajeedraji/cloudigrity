<?php
include("auth.php");
require('conn.php');
$id = $_REQUEST['id'];
$email  = $_SESSION['email'];

//$FileNo=$_GET['FileNO'];

//Use Mysql Query to find the 'full path' of file using $FileNo.
// I Assume $FilePaths as 'Full File Path'.


//E_fileData
$query = "SELECT * FROM files WHERE file_id =$id ";
$result = mysqli_query($con, $query) or  printf("Error message: %s\n", $mysqli->error);
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    $file = $row['E_fileData'];
    $hash2 = $row['hash'];

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // readfile($file);
        //  exit;
    }
    $hash = ($str1 = hash_file('sha3-512', $file));
    //  $str2 = "c48d3c6f13a4547a4e86688ad5e5aaea8aa066e44d739189f9c5b1db5b11a6a51ea929aae387a411a546f40019a12032aee9ea8d4b10dd89b6c4a8c7914b458e";
    if ($hash == $hash2) {

        $query = "SELECT * FROM files WHERE hash='$hash2 ' ";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if ($rows == 1) {
            $file_id = $row['file_id'];
            // echo  $file_id;
            //  "UPDATE `files` SET `digital_signature` = '$data1', `E_symKey` = '$data1' WHERE `files`.`hash` = $hash";
            $sql =   "  UPDATE `files` SET `status` = '1' WHERE `files`.`file_id` = $file_id ";
            if ($con->query($sql)) {
                echo "success";
            } else {
            }
        }
        $con->close();
        header("Location: index.php");
    } else {
        $query = "SELECT * FROM files WHERE hash='$hash2 ' ";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if ($rows == 1) {
            $file_id = $row['file_id'];
            // echo  $file_id;
            //  "UPDATE `files` SET `digital_signature` = '$data1', `E_symKey` = '$data1' WHERE `files`.`hash` = $hash";
            $sql =   "  UPDATE `files` SET `status` = '0' WHERE `files`.`file_id` = $file_id ";
            if ($con->query($sql)) {
                echo "success";
            } else {
            }
        }
        $con->close();
        header("Location: index.php");
    }
} else {
}


//$str2 = "c48d3c6f13a4547a4e86688ad5e5aaea8aa066e44d739189f9c5b1db5b11a6a51ea929aae387a411a546f40019a12032aee9ea8d4b10dd89b6c4a8c7914b458e";
//$check = strcmp($str1, $str2);
//if ($check === false) {
  //  echo "ssssssssssssssssss";
//}