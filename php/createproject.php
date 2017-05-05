
<?php

session_start();

if(isset($_SESSION['uid']))
{


// projname, projdescription, projminfundreq, projmaxfundreq, projfunddeadline, categoryid, tagname, projcoverimage, submit,

	if(isset($_POST['submit'])){

		require './connectdb.php';

		$error_projname = "";
		$error_projdescription = "";
		$error_projminfundreq = "";
		$error_projmaxfundreq = "";
		$error_projfunddeadline = "";
		$error_tagname = "";
		$error_categoryid = "";


// B+ trees , design problem, hash index or  T or false question, query optimization , do all the homework exercise, 
		$c_projname = "";
		$c_projdescription = "";
		$c_projminfundreq = "";
		$c_projmaxfundreq = "";
		$c_projfunddeadline = "";
		$c_tagname = "";
		$c_categoryid = "";

		//Code for image
		$file_dir = "../uploads/projectcover/";

		$file_name = $_FILES['projcoverimage']['name'];

		require 'imageuploadvalidate.php';


#$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);















	}



?>