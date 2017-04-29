<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CATALYZE</title>

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
                <a class="navbar-brand" href="index.html">WELCOME!!</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Two');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide Three');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Catalyze
                </h1>
            </div>
<?php
//Connect to Server and DB

require './php/connectdb.php';


$sql="Select * from project";
$fetch=mysqli_query($con,$sql);

while($row=mysqli_fetch_array($fetch))
{
$sql1="Select uname from user u, project p where u.uid=$row[projcreatorid]";
$fetch1=mysqli_query($con,$sql1);
$row1=mysqli_fetch_array($fetch1);
            echo "<div class='col-md-4'>";
                echo "<div class='panel panel-default'>";
                   echo "<div class='panel-heading'>";
                        echo "<h4>".$row['projname']."</h4>";
                        echo "by <h8>".$row1['uname']."</h8>";
                    echo "</div>";
                    echo "<div class='panel-body'>";
                        $desc=str_pad($row['projdescription'],50,' ');
                        echo "</div>";
                        echo "<p> ".substr($desc,0,50)."...."."</p>";
                        $fundstatus=($row['projfundcollected']/$row['projmaxfundreq'])*100;
                        $deadline=date_create($row['projfunddeadlinedatetime']);
                        $now = new DateTime();
                        $interval = $deadline->diff($now);
                        //echo date_format($deadline,'g:ia \o\n jS F Y')
                          //<a href='project.php' class='btn btn-default'>Learn More</a></div>";
                        echo "<div class='panel-footer'>Funding Deadline: ".$interval->format("%a days, %h hours");
                        echo "<br>Funds collected: $".$row['projfundcollected']."</br>";
                        echo "<br><h8>Funding Progress</h8></br>
                        <div class='progress'>
                                <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width:".$fundstatus."%'>
                                    <span class='sr-only'></span>".$row['projstatus']."
                                </div>
                        </div>
                        <div><a href='likes.php' class='btn btn-default'>
                                <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
                                <span class='sr-only'></span>Like</a>
                                <a><form action='./project/projsearch/proj.php' method='POST'>
                                <button id='".$row['projid']."' name='pname' value='".$row['projid']."' class='btn btn-default'>Learn More</button></form></a>";
                   echo "</div>
                   </div>
                </div>
            </div>";
}

?>

<!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>