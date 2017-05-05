<?php
//Session Checking 
 
session_start();
if(isset($_SESSION['uid']) ) 

{

?>


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

<?php
//Connect to Server and DB


    require './php/connectdb.php';


    $tag=$_GET['tagname'];
?>    

    <!-- Page Content -->
    <div class="container">

        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> &nbsp; <?php  echo $tag; ?> 

                        
                </h1>
            </div>
        </div>

<?php
    $sql="Select p.* from project p, projtags t where t.tag='".$tag."' and p.projid=t.projid";
    $fetch=mysqli_query($con,$sql);

    while($row=mysqli_fetch_array($fetch))
    {
        $sql1="Select uname from user u, project p where u.uid=$row[projcreatorid]";
        $fetch1=mysqli_query($con,$sql1);
        $row1=mysqli_fetch_array($fetch1);
        // For image if there is no image with project, place the default image:
        // Only for image $r_image tag is used

        $r_image = $row['projcoverimage'];

        $file_dir = "./uploads/projectcover/";
        $default_image = "projectdefault.png";
        $default_image_path = $file_dir . $default_image;

         if ($r_image == null or $r_image == '') 
        {
            // Show default image if no image specified
                $r_image =  $default_image_path; 
        }

            ?>

                    <div class='col-md-4'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <h4><?php echo $row['projname'];  ?></h4>
                                <h8><?php echo $row1['uname'] ?></h8>
                            </div>

                            <div class='panel-body'>
                                    
                                <!-- Showing Image of the project --> 
                                    <div class='row' style='margin-top:-15px; margin-right:-15px; margin-left:-15px;'>
                                         <img src=<?php echo $r_image; ?> class='center-block img-rectangle img-responsive' style=' position: relative;
                                           height:200px;  width:100%; background-position: 50% 50%'  />

                                    </div>

                    <?php
                                $desc=str_pad($row['projdescription'],50,' ');
                    ?>
                            </div>
                            <!-- Panel Body Closed -->

                                <p><?php echo substr($desc,0,50); ?> ... </p>
                    <?php            
                                $fundstatus=($row['projfundcollected']/$row['projmaxfundreq'])*100;
                                $deadline=date_create($row['projfunddeadlinedatetime']);
                                $dead = $deadline->format('m-d-Y H:i:s');
                    
                                //echo date_format($deadline,'g:ia \o\n jS F Y')
                                  //<a href='project.php' class='btn btn-default'>Learn More</a></div>";
                     ?>           
                            <div class='panel-footer'> Funding Deadline: <?php echo $dead; ?>
                                    <br>Funds collected: $ <?php echo $row['projfundcollected']; ?> </br>
                                    <br><h8>Funding Progress</h8></br>
                                <div class='progress'>
                                        <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style="width: <?php echo $fundstatus; ?>%; ">
                                            <span class='sr-only'></span> <?php echo $row['projstatus']; ?>
                                        </div>
                                </div>


                                <div class="row">
                                    
<!--
                                    <div class="col-md-3 col-lg-3 ">
                                        <form action='../phplikes.php' method='POST'>
                                            <input type='hidden' name='projid' id='projid' value=<?php echo $row['projid']; ?> />
                                                <button  name='setlikes' id='setlikes' value='submit' class='btn btn-default'>Like It? </button>
                                        </form>

                                    </div> -->

                                
                                    <!-- Request going to the Project page -->
                                    <div class="col-md-3 col-lg-3"> 
                                        <form action='./projsearch/proj.php' method='GET'>
                                                <input type='hidden' name='projectid' id = 'projectid' value=<?php echo $row['projid']; ?> />
                                                    <button  name='getproject' id='getproject' value='submit' class='btn btn-danger'>Learn More</button>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- Closing Panel Footer -->
                        </div> <!-- Closing Panel -->
                    </div> <!-- Closing col-md-4 -->
                        


<?php 

 } // While loop closing

?>

    </div>
    <!-- /.container -->
    
    <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->

</body>

</html>

<?php


    
} // Session if closing
else{
    header("Location: ./index.php");

}


?>

