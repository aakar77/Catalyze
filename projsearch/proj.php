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

    <title>CATALYZE-Project</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js" integrity="sha384-0s5Pv64cNZJieYFkXYOTId2HMA2Lfb6q2nAcx2n0RTLUnCAoTTsS0nKEO27XyKcY" crossorigin="anonymous"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js" integrity="sha384-ZoaMbDF+4LeFxg6WdScQ9nnR1QC2MIRxA1O9KWEXQwns1G8UNyIEZIQidzb0T1fo" crossorigin="anonymous"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="../index.php">Catalyze</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="page-scroll">
                        <a href="../dashboard.php"> Dashboard</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#page-top"> Project Details</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Project Description</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Gallery</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">Updates</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Comments</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!--project top page change-->
<div>
<head>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/portfolio-item.css" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <!-- Portfolio Item Heading -->
        <div class="row">
            <div class="col-lg-12">

<?php
//Connect to Server and DB
require '../php/connectdb.php';

$id=$_GET['projectid'];

// Fetching the project details from database
$sql="Select * from project where projid=$id";
$fetch=mysqli_query($con,$sql);
$result=mysqli_fetch_array($fetch);

// Fetching the user details from the database
$sql1="Select uid, uname from user u where u.uid=$result[projcreatorid]";
$fetch1=mysqli_query($con,$sql1);
$row1=mysqli_fetch_array($fetch1);

// Fetching the category the project belongs to from the database
$sql2="Select categoryname from category c where c.categoryid=$result[categoryid]";
$fetch2=mysqli_query($con,$sql2);
$row2=mysqli_fetch_array($fetch2);

// Fetching the tags associated with project.
$sql3="Select tag from projtags t where t.projid=$result[projid]";
$fetch3=mysqli_query($con,$sql3);

// Fetching no of likes 
$sql22="Select count(*) as liked from likes where projid=$id";
$fetch22=mysqli_query($con,$sql22);
$result22=mysqli_fetch_array($fetch22);

$deadline=date_create($result['projfunddeadlinedatetime']);
$dead = $deadline->format('m-d-Y H:i:s');


 //A For Checking whether the given user is already followed or not ..
    $already_liked = 0;
                        
    $projid = $id; // $id is the project id fetched from get parameter
    $user_session = $_SESSION['uid'];
    $user_name = $_SESSION['uname'];

    $sql_like_check = "select * FROM likes l where l.projid=".$projid." and l.uid=".$user_session;
                        
    $fetch_like_check=mysqli_query($con,$sql_like_check);
    $row_like_check= mysqli_num_rows($fetch_like_check);

    if($row_like_check != 0){
        $already_liked = 1;
    }
    // for checking whether already rated or no
    $already_rated = 0;
                        
    $projid = $id; // $id is the project id fetched from get parameter
    $user_session = $_SESSION['uid'];
    $user_name = $_SESSION['uname'];

    $sql_rate_check = "select * FROM rating r where r.projid=".$projid." and r.uid=".$user_session;
                        
    $fetch_rate_check=mysqli_query($con,$sql_rate_check);
    $row_rate_check= mysqli_num_rows($fetch_rate_check);

    if($row_rate_check != 0){
        $already_rated = 1;
    }

                        
?>
                <h1 class='page-header'><?php echo $result['projname'];?>
                <br/>
                <small>
<!-- See this is a form for seeing user profile --> 
                <form action='../php/userprofile1.php' method='GET' class="form-inline">
                    <input type='hidden' name='userid' value=<?php echo $row1['uid']; ?> />
                    <button id='User' name='User' class='btn btn-default btn-primary'>By <?php echo $row1['uname'] ?></button>
                    <div class="form-group">
                        <p>Posted on <?php echo date_format(date_create($result['projpostingdatetime']),'jS \o\f F,Y'); ?></p>
                    </div>
                </form>
                </small>
                <br/>



                <form id='like' action='javascript:insertlike()' class="form-inline">
                    <div class="form-group">
                        <h4><?php echo $result22['liked'];?></h4>
                    </div>

<?php 

            if($already_liked == 1){

             ?>
                <button class="btn btn-default" disabled>
                        <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
                        <span class='sr-only'></span>Liked
                </button>
    <?php 
               }
               else{
    ?>

                <button type="submit" class="btn btn-default">
                        <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>
                        <span class='sr-only'></span>Like
                </button>



                <?php
               }
?>


                    
            </form>
 <?php          
                if($result['projstatus']=='Active')
                {
                    echo "
                    <form id='sponsor' action='../sponsor.php' method='GET'>
                    <input type='hidden' name='projid' value=".$result['projid']." />
                    <button type='submit' value='submit' class='btn btn-success'>
                        <span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
                        <span class='sr-only'></span>Back This Project
                    </button>
                    </form>
                    ";
                }
            else if ($result['projstatus']=='Executed')
            {
                if($already_liked == 1)
                {
                echo
                "<form id='sponsor' action='../rating.php' method='GET'>
                    <input type='hidden' name='projid' value=".$result['projid']." />
                    <button type='submit' value='submit' class='btn btn-success' disabled>
                        <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                        <span class='sr-only'></span>Rated!
                    </button>
                </form>
                ";
                }
                else
                {
                    echo
                "<form id='sponsor' action='../rating.php' method='GET'>
                    <input type='hidden' name='projid' value=".$result['projid']." />
                    <button type='submit' value='submit' class='btn btn-success'>
                        <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                        <span class='sr-only'></span>Rate It!
                    </button>
                </form>
                ";
                }

            }
            else
            {
                echo "
                <form id='sponsor'  >
                    <input type='hidden' name='projid' value=".$result['projid']." />
                    <button disabled='disabled' type='submit' value='submit' class='btn btn-success'>
                        <span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
                        <span class='sr-only'></span>Thanks for Backing!
                    </button>
                </form>
                ";
            }
?>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class='row'>

            <div class='col-md-8'>
<?php

        $file_dir = "../uploads/projectcover/";
        $default_image = "projectdefault.png";
        $default_image_path = $file_dir . $default_image;

        $r_image = $result['projcoverimage'];

        if ($r_image == null or $r_image == '') {
            // Show default image if no image specified
            $r_image =  $default_image_path; 
        }
        else{
            $r_image = ".".$r_image;   
        }

?>
            <img class='img-responsive' src=<?php echo $r_image; ?> class='center-block img-rectangle img-responsive' style=' position: relative; height:100%;  width:100%; background-position: 50% 50%' alt=''>
            </div>
            <div class='col-md-4'>
                <h3>Project Details</h3>
                    <br><span class='glyphicon glyphicon-bullhorn' aria-hidden='true'></span>
                    <span class='sr-only'></span>Funding Status: <?php echo $result['projstatus']; ?></br>

                    <br><span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
                    <span class='sr-only'></span>Minimum Amount Required: <?php echo $result['projminfundreq']; ?></br>
                    
                    <br><span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
                    <span class='sr-only'></span>Maximum Amount Required: <?php echo $result['projmaxfundreq']; ?></br>
                    
                    <br><span class='glyphicon glyphicon-usd' aria-hidden='true'></span>
                    <span class='sr-only'></span>Fund Collected: <?php  echo $result['projfundcollected']; ?></br>
                    
                    <br><span class='glyphicon glyphicon-time' aria-hidden='true'></span>
                    <span class='sr-only'></span>Funding Deadline: <?php echo $dead; ?></br>
                    
                    <br><span class='glyphicon glyphicon-pushpin' aria-hidden='true'></span>
                    <span class='sr-only'></span>Project Category: <?php echo $row2['categoryname']; ?></br>
                    
                    <br><span class='glyphicon glyphicon-tags' aria-hidden='true'></span>
                    <span class='sr-only'></span>Project Tags:  
                   <?php

                    while($row3=mysqli_fetch_array($fetch3))
                        {
                         ?>
                         <form action='../related.php' method='GET'>
                                <button id='a'  name='tagname' value='<?php echo $row3['tag']; ?>' class="btn btn-default">
                                <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                <span class="sr-only"></span><?php echo $row3['tag']; ?></button>
                        </form>
                     <?php    
                        } 

                    ?>
                
        </div>
    </div>
</div>
</div>
<!--
<section id='Related Projects Row' class='bg-light-gray'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>
                <h3 class='page-header'>Related Projects</h3>
            </div>
            <!--panels for related projects

<?php 



$sql7="Select tag from projtags t where t.projid=$result[projid]";
$fetch7=mysqli_query($con,$sql7);

$sql9="Select categoryname from category c where c.categoryid=$result[categoryid]";
$fetch9=mysqli_query($con,$sql9);

$myarray=array();
while($row7=mysqli_fetch_array($fetch7) || $row9=mysqli_fetch_array($fetch9))
{
    //echo "heloo ".$row7['tag'];
    $sql6="Select distinct p.projid from project p, category c, projtags t where (p.categoryid=c.categoryid and c.categoryid=".$result['categoryid'].") or (p.projid=t.projid and t.tag='".$row7['tag']."')";
    
    $fetch6=mysqli_query($con,$sql6);
    $row6=mysqli_fetch_array($fetch6);

    while ($row6=mysqli_fetch_array($fetch6))
    {
        if(!in_array($row6['projid'], $myarray))
        $myarray[]=$row6['projid'];
        //print_r($myarray);
    }
}

while($myarray)
{
    $element=array_pop($myarray);
    $sql4="Select * from project where projid=$element";
    $fetch4=mysqli_query($con,$sql4);

    while($row4=mysqli_fetch_array($fetch4))
    {
        $sql5="Select u.uname, p.projcoverimage from user u, project p where u.uid=".$row4['projcreatorid'];
        $fetch5=mysqli_query($con,$sql5);
        $row5=mysqli_fetch_array($fetch5);

        $r_image = $row4['projcoverimage'];

        $file_dir = "../uploads/projectcover/";
        $default_image = "projectdefault.png";
        $default_image_path = $file_dir . $default_image;

        if ($r_image == null or $r_image == '') {
            // Show default image if no image specified
            $r_image =  $default_image_path; 
        }
        else{
            $r_image = ".".$r_image;   
        }





    ?>

                <div class='col-md-4'>
                    <div class='panel panel-default'>
                        
                        <div class='panel-heading'>
                            <h4><?php  echo $row4['projname']; ?></h4>
                            <h8> By <?php echo $row5['uname']; ?></h8>
                        </div>
                        
                        <div class='panel-body'>

                        <!-- Showing Image of the project 
                            <div class='row' style='margin-top:-15px; margin-right:-15px; margin-left:-15px;'>
                                 <img src=<?php echo $r_image; ?> class='center-block img-rectangle img-responsive' style=' position: relative;
                                   height:200px;  width:100%; background-position: 50% 50%' />
                            </div>

                        <?php

                             $desc=str_pad($row4['projdescription'],50,' ');
    
                        ?>
                            
                        </div>
                            
                            <p> <?php echo substr($desc,0,50); ?> ....</p>
                <?php 
                    $fundstatus1=($row4['projfundcollected']/$row4['projmaxfundreq'])*100;
                            
                    $deadline1=date_create($row4['projfunddeadlinedatetime']);
                    $now1 = new DateTime();
                    $interval1 = $deadline1->diff($now1);
                      
                            //echo date_format($deadline,'g:ia \o\n jS F Y')
                              //<a href='project.php' class='btn btn-default'>Learn More</a></div>";
                ?>            
                        <div class='panel-footer'>Funding Deadline: <?php echo $interval1->format("%a days, %h hours"); ?>
                            <br>Funds collected: $<?php echo $row4['projfundcollected']; ?></br>

                            <br><h8>Funding Progress</h8></br>

                            <div class='progress'>
                                        <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style="width: <?php echo $fundstatus1."%"; ?> ">
                                            <span class='sr-only'></span><?php echo $row4['projstatus']; ?>
                                        </div>
                            </div>

<!-- Setting the likes for the user, if already liked, liked with button disabled should be shown


                            <div class="row">
                                <div class="col-md-3 col-lg-3 ">
                                    <form action='../php/likes.php' method='POST'>
                                        <input type='hidden' name='projid' id='projid' value=<?php echo $row4['projid']; ?> />
                                        <button  name='setlikes' id='setlikes' value='submit' class='btn btn-default'>Like It? </button>
                                    </form>

                                </div>

                                
                                <!-- Request going to the Project page 
                                <div class="col-md-3 col-lg-3"> 
                                    <form action='./proj.php' method='GET'>
                                        <input type='hidden' name='projectid' id = 'projectid' value=<?php echo $row4['projid']; ?> />
                                        <button  name='getproject' id='getproject' value='submit' class='btn btn-default'>Learn More</button>
                                    </form>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
<?php   
    }
}
?>
        
            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">
                </a>
            </div>
</div>
        <!-- /.row 
        
    
</div>-->
</section>
    <!-- /.container -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    </div>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Project Description</h2>
                    <h3 class="section-subheading text-muted">
                        <?php echo "<p>$result[projdescription]</p></h3>";?>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Gallery</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/roundicons.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Round Icons</h4>
                        <p class="text-muted">Graphic Design</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/startup-framework.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Startup Framework</h4>
                        <p class="text-muted">Website Design</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/treehouse.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Treehouse</h4>
                        <p class="text-muted">Website Design</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/golden.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Golden</h4>
                        <p class="text-muted">Website Design</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal5" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/escape.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Escape</h4>
                        <p class="text-muted">Website Design</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal6" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img src="img/portfolio/dreams.png" class="img-responsive" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <h4>Dreams</h4>
                        <p class="text-muted">Website Design</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Updates</h2>
                    <h3 class="section-subheading text-muted">Keep track of the project's progress.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                   <?php
                    //echo $result['projid'];
                    $sql8="Select * from fundraise.update where projid=$result[projid] order by updatedatetime desc";
                    $fetch8=mysqli_query($con,$sql8);
                    $k=mysqli_num_rows($fetch8);
                    while($row8=mysqli_fetch_array($fetch8))
                    {
                        $n=$k%2;
                        $k=$k-1;
                    if($n==1)
                    {
                        echo "<li>
                            <div class='timeline-image'>
                                <img class='img-circle img-responsive' src='img/about/1.jpg' alt=''>
                            </div>
                            <div class='timeline-panel'>
                                <div class='timeline-heading'>";
                                   echo "<h4>".date_format(date_create($row8['updatedatetime']),'F j,Y')."</h4>
                                </div>";
                                echo "<div class='timeline-body'>
                                    <p class='text-muted'>";
                                    echo $row8['updatedescription'];
                                echo "</p>
                                </div>
                            </div>
                        </li>";
                    }
                    else
                    {
                        echo "<li class='timeline-inverted'>
                            <div class='timeline-image'>
                                <img class='img-circle img-responsive' src='img/about/2.jpg' alt=''>
                            </div>
                            <div class='timeline-panel'>
                                <div class='timeline-heading'>";
                                   echo "<h4>".date_format(date_create($row8['updatedatetime']),'F j,Y')."</h4>
                                </div>";
                                echo "<div class='timeline-body'>
                                    <p class='text-muted'>";
                                    echo $row8['updatedescription'];
                                echo "</p>
                                </div>
                            </div>
                        </li>";
                    }
                }
              //  }//end while
                        ?>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Be Part
                                    <br>Of Our
                                    <br>Story!</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="bg-light-gray">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Comments</h2>
                    <h3 class="section-subheading text-muted">Discussions about the project.</h3>
                </div>
            </div>
<div id="com">

<?php
    
    $sql9="Select * from comment where projid=$result[projid] order by cdatetime asc";
    $fetch9=mysqli_query($con,$sql9);

    $file_dir = "../uploads/user/";
    $default_image = "userdefault.jpg";
    $default_image_path = $file_dir . $default_image;




    while($row9=mysqli_fetch_array($fetch9))
{
    $sql10="Select uname, image from user where uid=$row9[uid]";
    $fetch10=mysqli_query($con,$sql10);
    $row10=mysqli_fetch_array($fetch10);
    $comtime=date_create($row9['cdatetime']);
    $r_image = $row10['image'];

      if ($r_image == null or $r_image == '') {
                        // Show default image if no image specified
                        $r_image =  $default_image_path; 
                     }



    echo "
    <article class='comment'>
    <a class='comment-img' href=''>
        <img src=".$r_image." alt='' width='50' height='50'>
      </a>
    <div class='comment-body'>
        <div class='text'>
          <p>".$row9['cdescription']."</p>
        </div>
        <p class='attribution'>by ";
        if ($user_name==$row10['uname'])
            {echo"<a href='../dashboard.php'>".$row10['uname']."</a> at ".date_format($comtime,'g:ia, jS F Y')."</p>";}
        else{
            echo"<a href='../php/userprofile1.php?userid=".$row9['uid']."'>".$row10['uname']."</a> at ".date_format($comtime,'g:ia, jS F Y')."</p>";
        }
        echo"
    </div>
      
    </article>
";
}

?>
</div>
<script type="text/javascript">
function insertlike()
{
    var li=<?php echo $result22['liked']; ?>;
    var id = <?php echo $result['projid']; ?>;
    $.ajax({
                url: '../php/likes.php',
                type: 'POST',
                data: {'projid': id},
                success: function(h)
                {
                    //window.location.reload(true);
                    var fi=li+1;
                    $("#like").html("<form id='like' class='form-inline'><div class='form-group'><h4>"+fi+"</h4></div><button type='submit' disabled='disabled' class='btn btn-default'><span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span><span class='sr-only'></span>Liked</button></form>");
                },
                error: function()
                {
                    alert("No");
                }
            });
}
function insertcomment()
{
    
    var comment=document.getElementById('id').value;
    var id = <?php echo $result['projid']; ?>;
   // var res= null;
    $.ajax({
                url: '../php/comment.php',
                type: 'POST',
                data: {'projid': id, 'comment': comment},
                success: function(data)
                {
                    Date.prototype.today = function () { 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
}

// For the time now
Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}
var datetime = new Date().today() + " at" + new Date().timeNow();
                    //res=data;
                    //alert(res);
                        /*var obj = $('<article class="comment">
    <a class="comment-img" href="">
        <img src="http://lorempixum.com/50/50/people/1" alt="" width="50" height="50">
      </a></article>');*/
    window.location.reload(true);
                       // $("#com ").append("<article class='comment'><a class='comment-img' href=''><img src='http://lorempixum.com/50/50/people/1' alt='' width='50' height='50'></a><div class='comment-body'><div class='text'><p>"+comment+"</p></div><p class='attribution'>by <a href='non'>Username</a> at"+datetime+"</p></div></article>"); 
                },
                error: function()
                {
                    alert("No");
                }
            });
}
</script>
    <article class='comment'>
    <a class='comment-img' href=''>
        <img src='http://lorempixum.com/50/50/people/1' alt='' width='50' height='50'>
      </a>
      <div class='comment-body'>
        <div class='text'>
        <form action="javascript:insertcomment()"/>
        <input type="text" name="comment" id="id" placeholder="Add comment...">
        </div>
        <button type="submit" value="submit" class='btn btn-default'>POST</button>
      </div>
    </article>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </section>

  <!--  <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Your Website 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>-->

    <!-- Portfolio Modals -->
    <!-- Use the modals below to showcase details about your portfolio projects! -->

    <!-- Portfolio Modal 1 -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/roundicons-free.png" alt="">
                                <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                <p>
                                    <strong>Want these icons in this portfolio item sample?</strong>You can download 60 of them for free, courtesy of <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">RoundIcons.com</a>, or you can purchase the 1500 icon set <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">here</a>.</p>
                                <ul class="list-inline">
                                    <li>Date: July 2014</li>
                                    <li>Client: Round Icons</li>
                                    <li>Category: Graphic Design</li>
                                </ul>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 2 -->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <h2>Project Heading</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/startup-framework-preview.png" alt="">
                                <p><a href="http://designmodo.com/startup/?u=787">Startup Framework</a> is a website builder for professionals. Startup Framework contains components and complex blocks (PSD+HTML Bootstrap themes and templates) which can easily be integrated into almost any design. All of these components are made in the same style, and can easily be integrated into projects, allowing you to create hundreds of solutions for your future projects.</p>
                                <p>You can preview Startup Framework <a href="http://designmodo.com/startup/?u=787">here</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 3 -->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/treehouse-preview.png" alt="">
                                <p>Treehouse is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. This is bright and spacious design perfect for people or startup companies looking to showcase their apps or other projects.</p>
                                <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/treehouse-free-psd-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 4 -->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/golden-preview.png" alt="">
                                <p>Start Bootstrap's Agency theme is based on Golden, a free PSD website template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Golden is a modern and clean one page web template that was made exclusively for Best PSD Freebies. This template has a great portfolio, timeline, and meet your team sections that can be easily modified to fit your needs.</p>
                                <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/golden-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 5 -->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/escape-preview.png" alt="">
                                <p>Escape is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Escape is a one page web template that was designed with agencies in mind. This template is ideal for those looking for a simple one page solution to describe your business and offer your services.</p>
                                <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/escape-one-page-psd-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 6 -->
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/portfolio/dreams-preview.png" alt="">
                                <p>Dreams is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Dreams is a modern one page web template designed for almost any purpose. It’s a beautiful template that’s designed with the Bootstrap framework in mind.</p>
                                <p>You can download the PSD template in this portfolio sample item at <a href="http://freebiesxpress.com/gallery/dreams-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha384-mE6eXfrb8jxl0rzJDBRanYqgBxtJ6Unn4/1F7q4xRRyIw7Vdg9jP4ycT7x1iVsgb" crossorigin="anonymous"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/agency.min.js"></script>

</body>

</html>

<?php 

}else{
    header("Location: ../index.php");

}


?>

