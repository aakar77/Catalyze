<?php
//Connect to Server and DB
header('Content-type: application/json');
$response_array = array();

//session_start();
//if(isset($_SESSION['uid'])){

if((isset($_POST['userid'])) and (isset($_POST['followsid']))){

	require './connectdb.php';

	$uid=$_POST['userid'];
	$followsid=$_POST['followsid'];
	//$uid = 6;
	//$followsid = 2;

	//change uid from the session value in the below query
	$sql1="insert into follows (uid,followsid) values ($followsid,$uid)";
	$fetch1=mysqli_query($con,$sql1);

	if($fetch1)
	{
		$response_array['status']="success";
	}
	else
	{
		$response_array['status']="error";
	}

}
else{
	$response_array['status'] = "error";
} 

echo json_encode($response_array);

?>