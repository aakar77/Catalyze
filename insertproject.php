<?php
//Connect to Server and DB
// Various entities for the database are:- 

require './php/sanitize.php';
date_default_timezone_set("America/New_York");
// projname, projdescription, projminfundreq, projmaxfundreq, projfunddeadline, categoryid, projcoverimage

session_start();

if(isset($_SESSION['uid'])){

	$error2 = "";
	$error_projname = "";
	$error_projdescription = "";
	$error_projminfundreq = "";
	$error_projmaxfundreq  = "";
	$error_projfunddeadline = "";
	$error_categoryid  = "";
	$error_projcoverimage ="";
	$error_projfunddeadline = "";
	$error_projtagname = "";



	$c_projname = $_POST['projname'];
	$c_projdescription = $_POST['projdescription'];
	$c_projminfundreq = $_POST['projminfundreq'];
	$c_projmaxfundreq  = $_POST['projmaxfundreq'];
	$c_projfunddeadline = $_POST['projfunddeadline'];
	$c_categoryid  = $_POST['categoryid'];
	//$c_projcoverimage = $_POST['projcoverimage']['name'];
	$c_tagname = $_POST['tagname'];

	$file_name = "";
	$file_name = $_FILES['profilePic']['name'];
	$file_path = NULL;

	if($file_name !=  null and $file_name != ''){

		$file_dir = "./uploads/projectcover/";
		require './php/imageuploadvalidate.php';
	}


	//Code for image
//	$file_dir = "./uploads/projcover/";

	if ($file_name != null and $file_name != ''){
		//require 'imageuploadvalidate.php';
	}

// 2017-01-30 18:34:11 Date time  for database
// For php date =  
	#$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


	// Validation  the project name
	if($c_projname == ""){
		$error_projname="Please provide project name";
	}
	else{
		if(strlen($c_projdescription) < 45 or strlen($c_projdescription) > 300){
			$error_projname="Please provide project description, meaningful and not vague \n";		
		}
	}

	// Validation project description
	if($c_projdescription == ""){
		$error_projdescription="Please provide project name";
	}
	else{
		if(strlen($c_projname) < 5 or strlen($c_projname) > 46){
			$error_projdescription="Please provide project name of proper length \n";		
		}
	}

	// Validation  the project minimum fund
	if(($c_projminfundreq == "") or ($c_projminfundreq == 0) or ($c_projminfundreq < 100) or ($c_projminfundreq >= 1000000)){
		$error_projminfundreq="Please provide proper project minimum fund";
	}

	// Validation  the project maximum fund
	if(($c_projmaxfundreq == "") or ($c_projmaxfundreq == 0) or ($c_projmaxfundreq < 100) or ($c_projmaxfundreq >= 1000000)){
		$error_projmaxfundreq="Please provide proper project maximum fund";
	}

	// Validation  the project minimum and maximum difference fund
	if(($c_projmaxfundreq < $c_projminfundreq)){
		$error_projmaxfundreq ="Please provide proper project funding details";
	}

	if(($c_categoryid == "")){
		$error_categoryid = "Please provide the categoryid";
	}

	// For funding deadline
	if($c_projfunddeadline == ""){
		$error_projfunddeadline = "Please provide proper funding campaign deadline";
	}
	else{
		$c_projfunddeadline = $c_projfunddeadline." 23:59:59";		

		if (new DateTime() > new DateTime($c_projfunddeadline)) {
			$error_projfunddeadline = "Hey ! Funding campaign date cannot be in past";
		}
	    # current time is greater than 2010-05-15 16:00:00 and thus in the past
	}

	if($c_tagname == ""){
		$c_tagname = null;
	}

	// if not null means file name is present and is uploaded by the user.

	/* Hometwon and rcontact can be NULL */
	/*
	echo $error_username;
	echo $error_email;
	echo $error_password;
	echo $error_hometown;
	echo $error_contact;
	*/

	if($error_projname == "" and $error_projdescription == "" and  $error_projminfundreq == "" and $error_projmaxfundreq == "" and $error_projfunddeadline == "" and $error_projcoverimage =="" and $error_projtagname == "" and $error_categoryid == ""){


		require './php/connectdb.php'; 
		
		//echo "Inside the function";

		// Sanitize custom function present in the file which contains necessary functions
		
		$c_projcreatorid = $_SESSION['uid'];
		$c_projname= sanitize_input($c_projname, $con);
		$c_projdescription = sanitize_input($c_projdescription, $con);
		$c_categoryid = sanitize_input($c_categoryid, $con);
		$c_projpostingdatetime = date('Y-m-d H:i:s'); 
		$c_projminfundreq = sanitize_input($c_projminfundreq, $con);
		$c_projmaxfundreq = sanitize_input($c_projmaxfundreq, $con);
		$c_projfunddeadline = sanitize_input($c_projfunddeadline, $con);
		$c_projfundraisedatetime = NULL;
		$c_projcompledatetime = NULL;
		$c_projstatus = "active";
		$c_projfundcollected = 0;	


		$c_tagname_a = "";

 echo $c_projcreatorid.":".$c_projname.":".$c_projdescription.":".$c_categoryid.":".$c_projpostingdatetime.":".$c_projminfundreq.":".$c_projmaxfundreq.":".$c_projfunddeadline.":".$c_projfundraisedatetime.":".$c_projcompledatetime.":".$c_projstatus.":".$file_path.":".$c_projfundcollected ;

		// Current date recalucalting
		// Current projcreatorid from session
		// Current status is equal to 'active'
		// projfundcollected is equal to 0
		// projcompletedatetime is null
		// projfundraisedatetime is null
		// projfunddeadlinedatetime == $c_projfunddeadline
		// projpostingdatetime == now


		$sql = "INSERT INTO `project` (`projcreatorid`, `projname`, `projdescription`, `categoryid`, `projpostingdatetime`, `projminfundreq`, `projmaxfundreq`, `projfunddeadlinedatetime`, `projfundraisedatetime`, `projcompledatetime`, `projstatus`, `projcoverimage`, `projfundcollected`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";



		if($stmt = $con->prepare($sql)){
			
			//echo $file_path;
			$stmt->bind_param("issisiisssssi", $c_projcreatorid, $c_projname, $c_projdescription, $c_categoryid, $c_projpostingdatetime, $c_projminfundreq, $c_projmaxfundreq, $c_projfunddeadline,$c_projfundraisedatetime,$c_projcompledatetime,$c_projstatus,$file_path, $c_projfundcollected);

//$stmt->bind_param("issisiisssssi",$a = 1, $b ='Back street boys music album',$c = 'new album metal music',$d = 302,$e = '2017-01-15 12:15:30',$f = 15000,$g = 20000,$f = '2017-09-18 22:15:17',NULL,NULL,$l = 'active',NULL,0);
/*
 = NULL;
		$c_projcompledatetime = NULL;
		$c_projstatus = "active";
		$c_projfundcollected = 0;	*/
		
			if($stmt->execute()){

				$projid = $stmt->insert_id;
	 			if($file_path != ''){
	                move_uploaded_file($temp,$file_path);                            
	            }
	            else {                
	                //echo 'File not included';
	            }

// For tags, inserting into the database

			if($c_tagname != null){
				$c_proj = sanitize_input($c_tagname, $con);
				$c_tagname_a = explode(" ", $c_proj);
			
				// Preparing to insert into tag table
				foreach($c_tagname_a as $tag) {


 				   $tag = trim($tag);

 				   $sql1 = "INSERT INTO `projtags` (`projid`, `tag`) VALUES (?,?)";


					if($stmt1 = $con->prepare($sql1)){
						$stmt1->bind_param("is",$projid,$tag);

						if($stmt1->execute()){

							// Successfully executed
						}
						else{


							// Error, 
						}

					}
					else{
						// I am not handling this

					}
				
				} // Foreach
			} // if

			header("Location: ./dashboard.php");
		
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

		$error2 = $error_projname."\n".$error_projdescription."\n".$error_projminfundreq."\n".$error_projmaxfundreq."\n".$error_projfunddeadline."\n".$error_projcoverimage."\n".$error_projtagname."\n".$error_categoryid;
		echo $error2;
	}
} // Session not set, redirect back
else{


}

	?>





