<?php

session_start();

if(isset($_SESSION['uid'])){

	require './connectdb.php';
	//Connect to Server and DB
	
	$amount=$_POST['amount'];
	$card=$_POST['card'];
	$projid=$_POST['projid'];
	$uid = $_SESSION['uid'];


	//convert exp to date time....change exp datatype in database
	$sql="select now() as time";
	$fetch=mysqli_query($con,$sql);
	$result=mysqli_fetch_array($fetch);
	//change uid from the session value in the below query
	$sql1="insert into sponsor values ($projid, $uid, $card, '".$result['time']."', $amount)";
	$fetch1=mysqli_query($con,$sql1);

	if($fetch1)
	{
		header("Location: http://localhost/project/index.php");
	}
	else
	{
		header("Location: http://localhost/project/sponsor.php?projid=$projid&sorry=Please Try Again!");
	}
	/*error=Card Not Added. Please try again!"*/

}else{

    header("Location: ../index.php");
}

?>