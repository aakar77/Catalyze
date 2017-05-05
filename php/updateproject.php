<?php
//Connect to Server and DB
// Various entities for the database are:- 

require './sanitize.php';
date_default_timezone_set("America/New_York");
// projname, projdescription, projminfundreq, projmaxfundreq, projfunddeadline, categoryid, projcoverimage

session_start();

if(isset($_SESSION['uid'])){

	$error2 = "";
	$error_updatedescription = "";

	$c_projid = $_POST['projectid'];
	$c_updatedescription = $_POST['updatedescription'];

	$file_name = "";
	$file_name = $_FILES['profilePic']['name'];
	$file_path = NULL;

	if($file_name !=  null and $file_name != ''){

		$file_dir = "../uploads/projectupdate/";
		require './imageuploadvalidate.php';
	}

// 2017-01-30 18:34:11 Date time  for database
// For php date =  

	// Validation project update description
	if($c_updatedescription == ""){
		$error_updatedescription="Please provide project update description";
	}
	else{
		if(strlen($c_updatedescription) < 45 or strlen($c_updatedescription) > 300){
			$error_updatedescription="Please provide project update description of proper length \n";		
		}
	}

	if($error_updatedescription == ""){


		require './connectdb.php'; 
		
		//echo "Inside the function";

		// Sanitize custom function present in the file which contains necessary functions
		
		
		$c_updatedescription = sanitize_input($c_updatedescription, $con);
		$c_projid = sanitize_input($c_projid, $con);
		$c_updatedatetime = date('Y-m-d H:i:s'); 
		
		
 //echo $c_projcreatorid.	

		$sql = "INSERT INTO `projectupdate`(`projid`, `updatedatetime`, `updatedescription`) VALUES (?,?,?)";

		if($stmt = $con->prepare($sql)){
			
			//echo $file_path;
			$stmt->bind_param("iss", $c_projid,$c_updatedatetime, $c_updatedescription);
		
			if($stmt->execute()){

// Inserting the image file in the image table
				$sql2 = "INSERT INTO `mediaattachment`(`projid`, `updatedatetime`, `mediauri`, `mtypeid`, `mcaption`) VALUES (?,?,?,?,?)";

				$c_filetype = 1;
				$c_caption = NULL;

				if($stmt2 = $con->prepare($sql2)){

					$stmt2->bind_param("issis", $c_projid,$c_updatedatetime,$file_path,$c_filetype,$c_caption);

					if($stmt2->execute()){

						if($file_path != ''){
	                		move_uploaded_file($temp,$file_path);                            
	            		}
	            		else {                
	                		//echo 'File not included';
	            		}
					}
					else{
							print $stmt2->error;
		  		
					}
				}
				else{
					echo " Failed to prepare the statement";
				}

			//header("Location: ./dashboard.php");
		
			}
		  	else{
		  		print $stmt->error;
		  		$error2 = "Insertion Failure !";
		  		echo $error2;
		  	}
		}
		else{
			echo "Insertion Error d";
		}

		//$stmt->close(); 
		$con->close();
	}
	else{

		$error2 = $error_updatedescription;
		echo $error2;
	}
} // Session not set, redirect back
else{


}

?>





