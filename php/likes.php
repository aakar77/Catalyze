
<?php
//Connect to Server and DB

require './connectdb.php';

$response_array = array();
$projid=$_POST['projid'];
//change uid from the session value in the below query
$sql1="insert into likes values ($projid, 1)";
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
?>