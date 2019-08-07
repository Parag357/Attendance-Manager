<?php
$host="localhost";
$dbusername="root";
$dbpassword="";
$dbname="attendance";
$con=mysqli_connect($host,$dbusername,$dbpassword,$dbname);
if(mysqli_connect_errno())
{
die("connection failed ".mysqli_connect_error()."<br>");  // this function is used to stop the script
}
?>
