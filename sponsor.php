<?php
//Session Checking 
 
session_start();
if(isset($_SESSION['uid'])){

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPONSOR A PROJECT</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php
//Connect to Server and DB
require './php/connectdb.php';
$s=@$_GET["error"];
echo $s;
$sorry=@$_GET["sorry"];
echo $sorry;
if(!$con)
{
    echo 'Not Connected to Server!!';
}

$projid=@$_GET['projid'];
// fetch all proj details
$sql="select * from project where projid=$projid";
$fetch=mysqli_query($con,$sql);
$result=mysqli_fetch_array($fetch);
$uid = $_SESSION['uid'];

//take uid from the session for below
// fetch all card details for this user
$sql1="select c.* from carddetail c, usercard u where u.cardno=c.cardno and u.uid=".$uid;
$fetch1=mysqli_query($con,$sql1);
$k=mysqli_num_rows($fetch1);

echo $k;

$sql2="select * from user u where u.uid=1";
$fetch2=mysqli_query($con,$sql2);
$row2=mysqli_fetch_array($fetch2);
?>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">PLEDGE FUNDS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="./index.php">Home</a>
                    </li>
                    <li>
                        <a href="./dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="./addcard.php?projid=<?php echo $projid;?>">Add Card</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<div class="container">
<form class="well form-horizontal" action="./php/insertsponsor.php" method="POST"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend>SPONSOR PROJECT: <?php echo $result['projname'];?></legend>

<?php
if(!$k)
{
    echo"
    <div class='alert alert-danger' role='alert'>Sorry! But we did not find any stored payment method.
  <a href='./addcard.php?projid=".$projid."' class='alert-link'>Please add your card details.</a>
</div>
";
}
?>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Enter Amount</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
  <input  name="amount" placeholder="99.00" class="form-control"  type="number" required>
  <input class="form-control" maxlength="3" id="securityCode" name="projid" type="hidden" value=<?php echo "'".$projid."'";?> required>
    </div>
  </div>
</div>

<!-- Select Basic -->
   
<div class="form-group"> 
  <label class="col-md-4 control-label">Card</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="card" class="form-control selectpicker" required>
      <option value=" " >Please select your stored card</option>
<?php

    while($row1=mysqli_fetch_array($fetch1))
    {
        echo "<option>".$row1['cardno']."</option>";
    }
?> 
    </select>
  </div>
</div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button type="submit" class="btn btn-success" >Send <span class="glyphicon glyphicon-send"></span></button>
    </div>
</div>  


</fieldset>
</form>

</div>
</div><!-- /.container -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>

    <script src="js/index2.js"></script>

    </div>

    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>


<?php
   
}else{
    header("Location: ./index.php");

}


?>

