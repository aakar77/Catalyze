<?php

session_start();
require 'sanitize.php';
$error = "";
if(isset($_POST['email']) and isset($_POST['password']) and validate_email($_POST['email'])){
	require_once 'connectdb.php'; 
	$c_uemail=$_POST['email'];

	//$Pass1=$_POST['password'];
	$c_upassword=hash('sha256', $_POST['password']);
	//echo $c_upassword;

	// Sanitize custom function present in the file which contains necessary functions
	$c_email = sanitize_input($c_uemail, $con);
	$c_upassword = sanitize_input($c_upassword, $con);


	//Query for user
	//Selecting a single row!
	$sql = "SELECT uid, uname, uemail, upassword FROM USER WHERE uemail = ? and upassword = ?";

	if($stmt = $con->prepare($sql)){
		
		$stmt->bind_param('ss', $c_uemail, $c_upassword);

		if($stmt->execute()){

			$stmt->store_result();

			if($stmt->num_rows ==1){

				 //echo "Success";

				$r_uid = "";
				$r_uemail = "";
				$r_upassword = "";
				$r_uname = "";

				$stmt->bind_result($r_uid, $r_uname, $r_uemail,$r_upassword);


	  			while ($stmt->fetch()) {

	  				if(($r_uemail == $c_uemail) and ($r_upassword == $c_upassword)){

	  					//echo "Successful Login";
                		//$_SESSION['email'] = $r_email;
                		$_SESSION['uid'] = $r_uid;
                		$_SESSION['uname'] = $r_uname;

                		//$con->close();

                		header("Location: ./dashboard.php");
                		exit();
					}
	  				else{
	  					$error = "Login Failure";
	  				}
	        	}

	        	$stmt->free_result();
				
			}
			else{

				$error = "Login Failure";
			}		
		}
		else{

			$error = "Login Failure";
			//echo "Failed in Query execution";
		}

	}
	else{

		$error = "Something might be wrong !! Login Failure";
		//echo "Failed in preparing the statement";
			//Send error
	}

	$stmt->close();
}
else{

	$error = "Please provide proper credentials";
	//echo "Please provide proper credentials.";
}


/*
$num_of_rows = $stmt->num_rows;


   while ($stmt->fetch()) {
        echo 'ID: '.$id.'<br>';
        echo 'First Name: '.$first_name.'<br>';
        echo 'Last Name: '.$last_name.'<br>';
        echo 'Username: '.$username.'<br><br>';
   }
*/


?>


