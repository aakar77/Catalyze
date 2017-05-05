
<?php
//Connect to Server and DB

session_start();

if(isset($_SESSION['uid'])){
	
	require './connectdb.php';

	$response_array = array();
	$projid=$_POST['projid'];
	$uid = $_SESSION['uid'];


	//change uid from the session value in the below query
	$sql1="insert into likes values ($projid, $uid)";
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

}else{
    header("Location: ../index.php");
}



//echo json_encode($response_array);
?>