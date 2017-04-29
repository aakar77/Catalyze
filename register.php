<?php
$host='localhost';
$user='root';
$pass='tiger';
$db='fundraise';
$con=mysqli_connect($host,$user,$pass,$db);
if(!$con)
{
	echo 'Not Connected to Server!!';
}
$Cname=$_POST['username'];
$Hometown=$_POST['hometown'];
$Phone=$_POST['contact'];
$Email=$_POST['email'];
$Pass=hash('sha256', $_POST['password']);
session_start();
$sql="INSERT INTO user (uid,uname,uemail,upassword,uhometown,ucontactno) values (10,'$Cname','$Email','$Pass','$Hometown','$Phone')";
if(!mysqli_query($con,$sql))
{
	header("Location: http://localhost/myapp/index.php?error=Please Select a different Customer Name!");
}
else{
header("Location: http://localhost/project/index.php");
}
?>