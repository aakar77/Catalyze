<?php

  $hostName = "localhost";
  $databaseName = "marketplace";
  $username = "root";
  $password = "root123";
  $conn = mysqli_connect($hostName,$username,$password,$databaseName);

  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " .mysqli_connect_errno();
  } /*
  else
  {
    echo " Yess, you win";
  }
  */


?>
