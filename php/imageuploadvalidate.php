<?php



	$error_file = '';

	//echo 'In file section';
	
	if($file_name != ''){

			//,
            $date = new DateTime();
			$name= hash('sha256',($date->getTimestamp()));
			$type= $_FILES["profilePic"]["type"];
			$size= $_FILES["profilePic"]["size"];
			$temp =$_FILES["profilePic"]["tmp_name"];
			$error = $_FILES["profilePic"]["error"];
            
            $file_path = '';

			if($error > 0)
			{

				$error_file ='Error uploading file!'. $error;
			}
			else
			{
				if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png"  || $type == "image/gif")
				{
			 		if($size > 3000000)
			 		{

						$error_file = 'File Size tooo big..';
					}
					else{
					    
                        if($type == "image/jpeg")
                        {
                            $name .= ".jpeg";
                        }
                        if($type == "image/jpg")
                        {
                            $name .= ".jpg";
                        }
                        if($type == "image/png")
                        {
                            $name .= ".png";
                        }
                        if($type == "image/gif")
                        {
                            $name .= ".gif";
                        }

						$file_path = $file_dir . $name;
						//move_uploaded_file($temp,$file_path);
						//echo $file_path;

					}
				}
				else
				{

					$error_file = 'File format not supported';
				}
			}
		}




?>