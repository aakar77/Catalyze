<?php
//Session Checking 
 
session_start();
if(isset($_SESSION['uid'])){

?>



<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Add Card</title>
  
      <link rel="stylesheet" href="css/style1.css">

  
</head>

<body>
  <html>

<head>
  <title>Catalyze-Add Card</title>
  <!-- Latest compiled and minified CSS -->
  <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" rel="stylesheet">
  <!-- Optional theme -->
  <link crossorigin="anonymous" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" rel="stylesheet">
  <!-- Latest compiled and minified JavaScript -->

  <script crossorigin="anonymous" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
  </script>
  <link href="styles.css" rel="stylesheet">
</head>

<body>
  <!---<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Panel title</h3>
        </div>
        <div class="panel-body">
            Panel content
        </div>
    </div>=-->

  <div class="container">
    <div id="payment-form">
      <div id="payment-form-header">
        Payment details
      </div>
<form action="./php/cardetails.php" method="POST"/>
<?php
echo "<p>".@$_GET["error"]."</p>";
//echo "<p>".@$_GET["projid"]."</p>";
?>
      <div id="payment-form-main" class="card-js">
        <label for="cardNumber">Card Number</label><br>
        <input class="form-control" id="cardNumber" maxlength="16" name="cardNumber" type="text" placeholder="2222-1111-3333-4444" required>
        <div class="col-xs-6">
          <label for="expiryDateMonth">Expiry Date
                    (mm/yy)</label><br>
          <input class="form-control" id="expiryDateMonth" maxlength="2" name="expiryDateMonth" placeholder=" &nbsp; MM &nbsp;" type="text" required> &nbsp; / &nbsp; 
          <input class="form-control" id="expiryDateYear" maxlength="2" name="expiryDateYear" placeholder=" &nbsp; YY &nbsp;" type="number" required>
        </div>
        <div class="col-xs-6">
          <label for="securityCode">Security Code/ CVV</label>
          <div class="form-group">
            <div class="input-group">
              <input class="form-control" maxlength="3" id="securityCode" name="securityCode" type="text" required>
              <input class="form-control" maxlength="3" id="securityCode" name="projid" type="hidden" value=<?php echo "'".@$_GET["projid"]."'";?> required>
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-question-sign"></span>
              </div>
            </div>
          </div>
        </div>
        <!--- ./col-xs-6 =-->
        <label for="nameOnCard">Name On The Card</label> <input class="form-control" id="nameOnCard" name="nameOnCard" type="text" required>
        <hr>
        <button type="submit" id="pay-now-button">ADD CARD</button>
       <hr>
      </div>
      <hr>
<a class="btn btn-default" href="./php/sponsor.php?projid=<?php echo @$_GET['projid']?>" role="button">GO BACK</a>
       <hr>
    </div>
  </div>
    <script src="js/index1.js"></script>
</body>
</html>

<?php
   
}else{
    header("Location: ./index.php");

}


?>
