<?php
include("auth.php");
require('conn.php');
$id = $_REQUEST['id'];
$email  = $_SESSION['email'];

$query = "SELECT * FROM files WHERE file_id =$id ";
$result = mysqli_query($con, $query) or printf("Error message: %s\n", $mysqli->error);
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    $File_Creator_Id = $row['File_Creator_Id'];
    $query = "SELECT * FROM users WHERE user_id ='$File_Creator_Id'";
    $result = mysqli_query($con, $query) or  printf("Error message: %s\n", $mysqli->error);
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if ($rows == 1) {
        $email1 = $row['email'];
        if (strcmp($email1, $email) == 0) {
            $query = "DELETE FROM files WHERE file_id =$id";
            $result = mysqli_query($con, $query) or  die("Error description: " . mysqli_error($con));

            header("Location: index.php");
        } else {
            echo "<script> alert('You cannot delete this file,as you are not the owner'); window.location.href='index.php';</script>";
        }
    } else
        echo "rrrrrrrrrrrrrr";
}
