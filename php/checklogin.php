<?php
        
if(isset($_POST['cusname'])){


    $cusname = stripslashes(htmlspecialchars($_POST['cusname']));
    $search = stripslashes(htmlspecialchars($_POST['search']));

    require 'connectdb.php'; 

    $cusname = mysqli_real_escape_string($conn, $cusname);
    $search = mysqli_real_escape_string($conn, $search);

    $cusname = str_replace('%', ' ', $cusname);
    $search = str_replace('%', ' ',$search);

    if($cusname){

        $query = @"SELECT cname FROM customer AS c WHERE c.cname = '{$cusname}'";

        if ($result = mysqli_query($conn,$query)){
          
            if (mysqli_num_rows($result) == 1){

                $row = $result->fetch_assoc();
                
                session_start();

                $_SESSION['cusname'] = $row['cname'];
                $_SESSION['search'] = $search;

                $conn->close();
                header("Location: ./dashboard.php"); // Double quoted is parsed for any variables it contains or not
                //header("Location: ./dashboard.php"); // Double quoted is parsed for any variables it contains or not


            }
            else{

                $error = "Customer name does not exists";
            }
        }
        else{
      
            $error = "Customer name does not exists";
            
        }
    
            $conn->close();    
    }
    else{        
        $error = "Sorry! 12 Customer name is invalid";
    }
} 
else{
    $error = "Customer name does not exists";
}
?>