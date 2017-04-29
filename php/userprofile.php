<?php

//$_POST['userid'] = 10;

//$c_uid = $_POST['userid'];


//if(isset($_POST['email']){

	$c_uid = 11;
	require 'connectdb.php'; 
	require 'sanitize.php';
	

	// Sanitize custom function present in the file which contains necessary functions
	$c_uid = sanitize_input($c_uid, $con);


	//Quick guide for user table uid uname uemail upassword uhometown ucontactno image
	//Query for getting User Profilee page information

	//Selecting a single row!
	$sql = "SELECT uname, uemail, uhometown, image  FROM USER WHERE uid = ?";

	if($stmt = $con->prepare($sql)){
		
		$stmt->bind_param('i', $c_uid);

		if($stmt->execute()){

			$stmt->store_result();

			if($stmt->num_rows == 1){

				 //echo "Success";

				$r_uname = "";
				$r_uemail = "";
				$r_uhometown = "";
				
				$r_image = "";

				$stmt->bind_result($r_uname, $r_uemail,$r_uhometown,$r_image);

	  			while ($stmt->fetch()) {

	  				echo 'User Name: '. $r_uname;
	  				echo 'Home Town: '. $r_uhometown;
	  				echo 'User Email: '.$r_uemail; 
						

?>
				<img src="<?php echo $r_image; ?>" class="img-circle" />
<?php
				}
				$stmt->free_result();
				
			}
			else{


			
			}		
		}
		else{

		
		}

	}

	/*
	else{

		
	}

	$stmt->close();
}
else{


	
}

*/

?>


