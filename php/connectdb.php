 <?php

  $hostName = "localhost";
  $databaseName = "fundraise";
  $username = "root";
  $password = "root123";
  $con = mysqli_connect($hostName,$username,$password,$databaseName);

  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " .mysqli_connect_errno();
  } 


  /*
  else
  {
    echo " Yess, you win";
  }



  */





/*
$result = mysql_query("select * from user_image  order by id desc");
echo "<table id='tbl' class='display' cellspacing='0' width='100%'>"; // start a table tag in the HTML
echo " <thead>
            <tr>
                <th>id</th>
                <th>image</th>
                <th>caption</th>
         <th>Upload Time</th>
             </tr>
        </thead><tbody>";
while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
echo "<tr><td>" . $row['id'] . "</td>" ;
 echo "<td><img src=".$row['image']." height='50px' width='50px'></td>";
echo "<td>" . $row['caption'] . "</td>";
echo "<td >" . $row['upload_time'] . "</td>" ;
echo "</tr>";
}
*/










?>




