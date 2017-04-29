<?php

    session_start();
    //echo $_SESSION['cusname'];

    if(isset($_SESSION['cusname'])){

        require './php/connectdb.php';

        $query = @"SELECT c.cname FROM customer AS c WHERE c.cname = '{$_SESSION['cusname']}'";

        if ($result = mysqli_query($conn,$query)){
          
            if (mysqli_num_rows($result) == 1){

                  //  if(isset($_SESSION['search']) && !empty($_SESSION['search'])){

                        //session_start();
                       // $var = $_SESSION['search'];
                       // header('Location: ./dashboard.php?search=$var');
                  //  }
                  //  else if(isset($_SESSION['search']) && empty($_SESSION['search'])){
              //  header('Location: ./dashboard.php');
                    // }
            }
            else
            {
                session_destroy();
                header('Location: ./index.php');
            }
            $conn->close();         
        }
    }
    else
    {
        session_destroy();
        header('Location: ./index.php');
    }
    
?>
