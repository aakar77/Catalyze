<?php

 #include_once 'php/checksession_simple.php';

 if(isset($_POST['login']))
  {
    include 'php/logincheck.php';
  }
  /*if(isset($_POST['register']))
  {
    include 'php/register.php';
  }*/
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CATALYZE</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

  <link rel="stylesheet" href="css1/style.css">
</head>

<body>
  <div class="login-page" ng-app="">

  <div class="login-content login-content-signin" ng-hide="showSignIn">
    <div>
      <h2>Log in</h2>
      <form class="wrapper-box" role="form" action="login.php" method="POST" novalidate>

          <?php if(isset($error)){
                  echo '<div class="alert alert-danger">
                        <strong>
                          ' . $error . '
                        </strong>
                        </div>';
                  }
          ?>

        <input type="email" name="email" id = "email" class="form-control form-control-email" placeholder="Email address" novalidate></input>
        <input type="password" name="password" id="password" class="form-control form-control-password" placeholder="Password" novalidate></input>
        <button type="submit" name="login" id="login" class="btn btn-submit btn-default pull-right">Log in</button>
      </form>
    </div>
  </div>
  <div class="login-content login-content-signup ng-hide" ng-show="showSignIn">
    <div>
      <h2>Sign Up</h2>

  <?php if(isset($error2)){
                  echo '<div class="alert alert-danger">
                        <strong>
                          ' . $error2 . '
                        </strong>
                        </div>';
                  }
          ?>


      <form class="wrapper-box" method="POST" enctype="multipart/form-data" action="login.php"  novalidate>
        <input type="text" name="rusername" id="rusername" class="form-control form-control-username" placeholder="Username" required></input>
        <input type="email" name="remail" id="remail" class="form-control form-control-email" placeholder="Email address" required></input>
        <input type="password" name="rpassword" id="rpassword" class="form-control form-control-password" placeholder="Password" required></input>
        <input type="text" name="rhometown" id="rhometown" class="form-control form-control-password" placeholder="Hometown" required></input>
        <input type="text" name="rcontact" id="rcontact" class="form-control form-control-password" placeholder="Contact No." required></input>
        <input type="file" name="profilePic" id="profilePic" accept="image/gif,image/jpeg,image/png,image/jpg"  placeholder="Please choose your Profile picture"> </input>
        <button type="submit" name="register" id="register" class="btn btn-submit btn-default pull-right">Sign up</button>
        <!-- The button name is register -->
profilePic
      </form>
    </div>
  </div>
<div class="login-switcher">
  <div class="login-switcher-signin" ng-show="showSignIn">
      <h3>Have an account?</h3>
      <button ng-click="showSignIn=false">Login</button>
    </div>

    <div class="login-switcher-signup" ng-hide="showSignIn">
      <h3>Don't have an account?</h3>
      <button ng-click="showSignIn=true">Sign Up</button>
    </div>
  </div>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.5/angular.min.js'></script>

</body>
</html>
