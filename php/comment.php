<?php
//Connect to Server and DB
session_start();

if(isset($_SESSION['uid'])){

	require './connectdb.php';	
	

	$uid=$_SESSION['uid'];
	$response_array = array();
	$comment=$_POST['comment'];
	$projid=$_POST['projid'];
	$sql="select now() as time";
	$fetch=mysqli_query($con,$sql);
	$result=mysqli_fetch_array($fetch);
	//change uid from the session value in the below query
	$sql1="insert into comment values ($projid, $uid, '".$result['time']."','".$comment."')";
	$fetch1=mysqli_query($con,$sql1);
	if($fetch1)
	{
		$response_array['sta']=101;
		//$response_array['succ']=101;

	}
	else
	{
		$response_array['status']=0;
	}
	echo $projid;
//echo json_encode($response_array);

}else{
    header("Location: ../index.php");

}


?>