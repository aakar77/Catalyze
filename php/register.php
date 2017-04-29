<?php
//Connect to Server and DB

require 'sanitize.php';


$error2 = "";
$error_username = "";
$error_password = "";
$error_hometown = "";
$error_contact  = "";
$error_email = "";


$c_username = $_POST['rusername'];
$c_email = $_POST['remail'];
$c_password = $_POST['rpassword'];
#$c_password = hash('sha256', $_POST['rpassword']);
$c_hometown = $_POST['rhometown'];
$c_contact = $_POST['rcontact'];


//Code for image
$file_dir = "../uploads/user/";

$file_name = $_FILES['profilePic']['name'];

require 'imageuploadvalidate.php';


#$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


// Validation  the username
if($c_username == ""){
	$error_username="Please provide username \n";
}
else{
	if(strlen($c_username) < 2 or strlen($c_username) > 46){
		$error_username="Please provide username of proper length \n";		
	}
}

// Validation for email with proper format and with proper length
if($c_email == ""){
	$error_email="Please provide email";
}
else{
	if(!validate_email($c_email)){
		$error_email="Please provide email in proper format \n";		
	}
	else if(strlen($c_email) < 2 or strlen($c_email) > 46){
		$error_email = "Please provide email of proper length \n";
	}
}


// Validation for password with Null and length
if($c_password == ""){
	$error_password = "Please provide your desired password \n";
}
else{
	if(strlen($c_password) < 8 and strlen($c_password) > 46){

		$error_password = "Please provide password of proper length \n";	

	}
}

// Validation for hometown with lenght
if($c_hometown != ""){

	if(strlen($c_hometown) > 46){
		$error_hometown = "Please provide hometown length within 45 charcterrs \n";
	}
}

// Validation for contact number foe length
if($c_contact != ""){

	if(!(preg_match('/^\d{10}$/',$c_contact))){
		$error_contact = "Please provide contact number of length 10 \n";
	}
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

if($error_username == "" and $error_email == "" and  $error_password == "" and $error_hometown == "" and $error_contact == "" and $error_file =="" ){


	require 'connectdb.php'; 
	
	echo "Inside the function";

	// Sanitize custom function present in the file which contains necessary functions
	$c_username = sanitize_input($c_username, $con);
	$c_email = sanitize_input($c_email, $con);
	$c_password = sanitize_input($c_password, $con);

	
	if($c_hometown == ""){
		$c_hometown = null;
	}
	else{
		$c_hometown = sanitize_input($c_hometown, $con);
	}

	if($c_contact == ""){
		$c_contact = null;
	}
	else{
		$c_contact = sanitize_input($c_contact, $con);

	}
	$c_password=hash('sha256',$c_password);

//	echo "Inside the functions";
	//Query for user
	//Selecting a single row!



	$sql = "INSERT INTO USER (`uname`, `uemail`, `upassword`, `uhometown`, `ucontactno`,`image`) VALUES (?,?,?,?,?,?)";
	
	if($stmt = $con->prepare($sql)){
		
		echo $file_path;

		$stmt->bind_param("ssssis", $c_username,$c_email,$c_password,$c_hometown,$c_contact,$file_path);
	
		if($stmt->execute()){

 			if($file_path != ''){
                move_uploaded_file($temp,$file_path);                            
            }
            else {                
                //echo 'File not included';
            }

			header("Location: ./dashboard.php");
	
		}
	  	else{
	  		$error2 = "Insertion Failure !";
	  		echo $error2;
	  	}
	}
	else{
		echo "Insertion Error";

	}

	$stmt->close();
}
else{

	$error2 = $error_email . $error_contact . $error_username . $error_password . $error_hometown . $error_file;
	echo $error2;
}

?>





