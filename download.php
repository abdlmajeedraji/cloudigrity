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
    $E_fileData = $row['E_fileData'];
    //  echo $E_fileData;
    download_file($E_fileData); //calling the function
    $con->close();
} else
    printf("Error message: %s\n", $mysqli->error);


function download_file($fullPath)
{
    if (headers_sent())
        die('Headers Sent');


    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');


    if (file_exists($fullPath)) {

        $fsize = filesize($fullPath);
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);

        switch ($ext) {
            case "pdf":
                $ctype = "application/pdf";
                break;
            case "exe":
                $ctype = "application/octet-stream";
                break;
            case "zip":
                $ctype = "application/zip";
                break;
            case "doc":
                $ctype = "application/msword";
                break;
            case "xls":
                $ctype = "application/vnd.ms-excel";
                break;
            case "ppt":
                $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            default:
                $ctype = "application/force-download";
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"" . basename($fullPath) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        ob_clean();
        flush();
        readfile($fullPath);
    } else
        die('File Not Found');
}
