<?php
include("conn.php");
session_start();
$password = $_POST['password'];
//$password = $_GET['password'];
$email  = $_SESSION['email'];

//Checking is user existing in the database or not
$query = "SELECT * FROM digitatl_certificate WHERE email='$email' and password='$password'";
$result = mysqli_query($con, $query) or die(mysqli_error());
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if ($rows == 1) {
    header("Location: index.php"); // Redirect user to home.html
} else {
?>
    <script>
        alert('Incorrect Key Pairs Password');
        location = "login.html";
    </script>
<?php
}
?>