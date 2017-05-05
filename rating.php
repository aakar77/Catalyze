<?php
//Session Checking 
session_start();
if(isset($_SESSION['uid'])){
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Rating Project</title>
  <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style4.css">

</head>
<?php
//Connect to Server and DB
require './php/connectdb.php';

$user_session = $_SESSION['uid'];
$user_name = $_SESSION['uname'];
$projid=@$_GET['projid'];
// fetch all proj details
$sql="select * from project where projid=$projid";
$fetch=mysqli_query($con,$sql);
$result=mysqli_fetch_array($fetch);
$uid = $_SESSION['uid'];
?>

<body>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

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
                <a class="navbar-brand" href="index.html">Catalyze</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="./index.php">Back</a>
                    </li>
                    <li>
                        <a href="./dashboard.php">Dashboard</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<hr>
<!-- RATING - Form -->
<div class="container">
<form class="rating-form" action="./php/insertrating.php" method="get" name="rating-project">
  <fieldset class="form-group">

    <legend >Rating: <?php echo $result['projname'];?></legend>
    
    <div class="form-item">
      
      <input id="rating-5" name="rating" type="radio" value="5" />
      <label for="rating-5" data-value="5">
        <span class="rating-star">
          <i class="fa fa-star-o"></i>
          <i class="fa fa-star"></i>
        </span>
        <span class="ir">5</span>
      </label>
      <input id="rating-4" name="rating" type="radio" value="4" />
      <label for="rating-4" data-value="4">
        <span class="rating-star">
          <i class="fa fa-star-o"></i>
          <i class="fa fa-star"></i>
        </span>
        <span class="ir">4</span>
      </label>
      <input id="rating-3" name="rating" type="radio" value="3" />
      <label for="rating-3" data-value="3">
        <span class="rating-star">
          <i class="fa fa-star-o"></i>
          <i class="fa fa-star"></i>
        </span>
        <span class="ir">3</span>
      </label>
      <input id="rating-2" name="rating" type="radio" value="2" />
      <label for="rating-2" data-value="2">
        <span class="rating-star">
          <i class="fa fa-star-o"></i>
          <i class="fa fa-star"></i>
        </span>
        <span class="ir">2</span>
      </label>
      <input id="rating-1" name="rating" type="radio" value="1" />
      <label for="rating-1" data-value="1">
        <span class="rating-star">
          <i class="fa fa-star-o"></i>
          <i class="fa fa-star"></i>
        </span>
        <span class="ir">1</span>
      </label>
      
      <div class="form-action">
        <input class="btn-reset" type="reset" value="Reset" />   
      </div>

      <div class="form-output">
        ? / 5
      </div>
      <br/>

      <div>
         <form action='' method='GET'>
                                <button id='a'  name='projid' value="<?php echo $result['projid'];?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
                                <span class="sr-only"></span>SUBMIT</button>
          </form>
      </div>
    </div>
  </fieldset>
</form>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>
<?php
   
}else{
    header("Location: ./index.php");
}
?>