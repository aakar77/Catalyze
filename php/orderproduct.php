<?php

header('Content-type: application/json');


session_start();

$response_array = array();


if(isset($_SESSION['cusname'])){

	if(isset($_POST['pname']) && isset($_POST['pstatus']) ){


		// We are getting all the variables from the AJAX request successfully.
	
		/*	FOR UPDATING CHECKING
			Ivy Yu La Roche-Posay Effaclar Medicated Gel 2017-03-20 14:05:59 1 14.99 pending */

		/* FOR INSERTION CHECKING
			Antonio Rod Fire Kids Edition Tablet 
		*/

		$pname = $_POST['pname'];
		$pstatus = $_POST['pstatus'];
		$cname = $_SESSION['cusname'];

/*
		$pname = 'Fire Kids Edition Tablet';
		$pstatus = 'available';
		$cname = 'Antonio Rod'; */

		// Simply return error if the product is discontinued
		if($pstatus != 'discontinued'){

			require 'connectdb.php';


	   		$pname = mysqli_real_escape_string($conn, $pname);
	   		$pstatus = mysqli_real_escape_string($conn, $pstatus);
			$cname = mysqli_real_escape_string($conn, $cname);

			//2017-03-21 15:06:28 Time format of database

			date_default_timezone_set('America/New_York');
			$date = date('Y-m-d h:i:s', time());
			//echo $date;

			$query = @"SELECT p.cname, p.pname, p.status, t.pprice FROM purchase p INNER JOIN product t ON p.pname = t.pname WHERE p.cname = '{$cname}' AND p.pname = '{$pname}' AND p.status = 'pending'";

        	if ($result = mysqli_query($conn,$query)){
          
            	if (mysqli_num_rows($result) == 1){

            			$row2 = $result->fetch_assoc();
            			$pprice = $row2['pprice']; 

            			// Purchase having status pending is already present in the database
            			// Just update the order by incrementing the quantity, updating the new date and incrementing the price

            			$query_update = @"UPDATE purchase 
										SET quantity = quantity + 1, puprice = puprice + '{$pprice}', putime = '{$date}'
										WHERE pname = '{$pname}' AND cname = '{$cname}'";

					if($result1 = mysqli_query($conn,$query_update)){

						//echo "Successfully Updated record";
						$response_array['success'] =  "Congratulations !! You have successfully updated your order";
						$response_array['status'] = "success";


					}
					else{
						//echo "Failed to update the record";
						
						$error = 'Sorry!! Failed to Update into the database';
						$response_array['error'] =  $error;
						$response_array['status'] = "error";

					}
	            }
	            else if(mysqli_num_rows($result) == 0){
	            	// This is the condition where we have to insert the value into the database. As this is new order not an existing order.
	            	
	            	// Fetching the price of the product first from the datbase
					$query_getprice = @"SELECT pprice FROM product WHERE pname='{$pname}' AND pstatus <> 'discontinued' ";

	            	if ($result2 = mysqli_query($conn,$query_getprice)){
          
            			if (mysqli_num_rows($result2) == 1){


            				$row = $result2->fetch_assoc();
            				$puprice = $row['pprice'];
            				$pname = $pname;
            				$cname = $cname;

            				//echo $puprice;

            				$quantity = 1;
            				$status = "pending";

            				$query_insert = @"INSERT INTO purchase (cname,pname,putime,quantity,puprice,status)
            								VALUES('$cname','$pname','$date','$quantity','$puprice','$status')";

            				if($result3 = mysqli_query($conn, $query_insert)){

            					//echo "Successfully inserted new data into the database";

            					$response_array['success'] =  "Congratulations !! You have successfully ordered the product";
            					// Successfully inserted into the database

            					$response_array['status'] = "success";
            				}	
            				else{
            					// Condition where we failed to insert value into the database
            					$error = 'Sorry!! Failed order the product d';
								$response_array['error'] =  $error;
								$response_array['status'] = "error";

            					//echo "Failed to insert value into the database";
            					//$error = "Failed to insert value into the database";
            				}
            			}
            			else{
            				// The condition when we failed to fetch the price of the product from the dataabase
            				$error = 'Sorry!! Failed order the product c';
							$response_array['error'] =  $error;
						
            			}
            		}
            		else{

            			//echo "Not able to executed query Failed to fetch the price from the database";
            			$error = 'Sorry!! Failed order the product b';
						$response_array['error'] =  $error;
						$response_array['status'] = "error";

            		}
	
	            }
    		}
            else
            {
   					$error = 'Sorry!! Failed order the product a';
					$response_array['error'] =  $error;

            		$response_array['status'] = "error";
   				
            }
            $conn->close();      
		}
		else{

			// Send error that the product having status discontinued is not available
			$error = 'Sorry!! Failed order the product. You cannot order the product whose status is discontinued';
			$response_array['error'] =  $error;
			$response_array['status'] = "error";
		}
}
	else{

		// Send error such that we are not getting the desired variables from the request made.
		$error = 'Sorry!! Failed order the product. ff';
		$response_array['error'] =  $error;

		$response_array['status'] = "error";

		//echo "The desired variable is not set";
	} 
}
else{

	// Check if the session is set or not, if the seesion is not set in that case redirect the user to front page.
	// No need to send error variable. Just redirect the user to the front page.
	// This is for security reason for protecting of th website.
    
    header('Location: ./index.php');
}

echo json_encode($response_array);

?>
