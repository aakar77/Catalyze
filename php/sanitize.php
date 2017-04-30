<?php

	function sanitize_input($data, $con)
	{
	 	
	 	$data = htmlspecialchars($data);
	 	$data = stripcslashes($data);
	 	$data = mysqli_real_escape_string($con, $data);

	  	return $data;
	}

	function validate_email($data){
		
		if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
  			return (false);
		}
		return (true);
	}

?>