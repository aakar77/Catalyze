<?php
//Connect to Server and DB
 
session_start();

if(isset($_SESSION['uid'])){

	require './connectdb.php';


	$cardno=$_POST['cardNumber'];
	$cardname=$_POST['nameOnCard'];
	$expyear=$_POST['expiryDateYear'];
	$expmonth=$_POST['expiryDateMonth'];
	$cvv=$_POST['securityCode'];
	$projid=$_POST['projid'];
	//echo $projid;
	//$uid = take from session
	//convert exp to date time....change exp datatype in database


	$sql="insert into carddetail values ($cardno, cardexp,'".$cardname."',$cvv)";
	$fetch=mysqli_query($con,$sql);
	//$uid take from session
	//change uid from the session value in the below query
	$sql1="insert into usercard values ($cardno, 1)";
	$fetch1=mysqli_query($con,$sql1);

	if($fetch1 && $fetch)
	{
		header("Location: http://localhost/project-20170430T163142Z-001/project/sponsor.php?success=Card Successfully Added!&projid=$projid");
	}
	else
	{
		header("Location: http://localhost/project-20170430T163142Z-001/project/addcard.php?error=Card Not Added. Please try again!&projid=$projid");
	}
/*error=Card Not Added. Please try again!"*/

}
else{
  	header("Location: ../index.php");
}

?>