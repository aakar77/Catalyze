<?php
//Connect to Server and DB
session_start();

if(isset($_SESSION['uid'])){

	require './connectdb.php';	

	$uid=$_SESSION['uid'];
	$rating=$_GET['rating'];
	$projid=$_GET['projid'];
	$sql="select now() as time";
	$fetch=mysqli_query($con,$sql);
	$result=mysqli_fetch_array($fetch);
	$sql1="insert into rating values ($projid, $uid, '".$result['time']."', $rating)";
	$fetch1=mysqli_query($con,$sql1);
	if($fetch1)
	{
		header("Location: http://localhost/project/projsearch/proj.php?projid=$projid");
	}
}
else{
    header("Location: ../index.php");

}


?>