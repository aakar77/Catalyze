<!-- This is the Dashboard for seeing projects You Have Sponsored --> 

<?php

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

    <title>Catalyze</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Catalyze</a>
            </div>
            
            <!-- Top Menu Items ON RIGHT SIDE-->
            <ul class="nav navbar-right top-nav">
                
                <!-- For Showing Notifications If possible to implement -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>

                <!-- Update the Name of the User HERE -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $_SESSION['uname']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="./php/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>


            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
           <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
                    </li>
                    <li >
                        <a href="dashboard1.php"><i class="fa fa-fw fa-dashboard"></i>Your Projects</a>
                    </li>
                    <li >
                        <a href="dashboard2.php"><i class="fa fa-fw fa-plus"></i>Create New Project</a>
                    </li>
                    <li>
                        <a href="dashboard3.php"><i class="fa fa-fw fa-share"></i>Your Sponsored Projects</a>
                    </li>
                    <li class="active">
                        <a href="dashboard4.php"><i class="fa fa-fw fa-heart"></i>Project's Liked</a>
                    </li>
                    <li>
                        <a href="dashboard5.php"><i class="fa fa-fw fa-arrow-right"></i>User's Followed</a>
                    </li>
                    <li>
                        <a href="dashboard6.php"><i class="fa fa-fw fa-arrow-left"></i>User's Following</a>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i>Your Own Profile</a>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-edit"></i>Update Project</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


        <div id="page-wrapper" style=".fill {  min-height: 100%; height: 100%; }">

            <div class="container-fluid" style=".fill {  min-height: 100%; height: 100%; }">

<?php 

    require './php/connectdb.php';

    $c_uid = $_SESSION['uid'];

    $sql="Select COUNT(l.projid) as likecount from likes l where l.uid=".$c_uid;

    $fetch=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($fetch);

    $likecount = $row['likecount'];

    if ($likecount == null){
        $likecount = 0;
    }



?>

     <div id="page-wrapper" style=".fill {  min-height: 100%; height: 100%; }">

            <div class="container-fluid" style=".fill {  min-height: 100%; height: 100%; }">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <h1 class="page-header">
                           <i class="fa fa-heart"></i>Project's Liked <!-- <small>Projects Overview</small> -->
                        </h1>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h1 class="page-header">
                            <i class="fa fa-unchecked"></i>No. Project's Liked : <?php echo $likecount; ?>
                        </h1> 
                    </div>
                </div>
                <!-- /.row -->

<?php


    $sql1="Select * from project p where p.projid IN (SELECT l.projid FROM likes l WHERE l.uid=".$c_uid.")";

    $fetch1=mysqli_query($con,$sql1);

    //---->    // Fetching row count for checking if there are any rows returned or not
    $row_cnt = mysqli_num_rows($fetch1);

    if($row_cnt != 0){
                        



    while($row1=mysqli_fetch_array($fetch1))
    {
        // Fetching the user name and user ID
        
        $sql2="Select u.uname from user u, project p where u.uid=".$row1['projcreatorid'];
        $fetch2=mysqli_query($con,$sql2);
        $row2=mysqli_fetch_array($fetch2);

        // For showing project image
        $r_image = $row1['projcoverimage'];

        $file_dir = "./uploads/projectcover/";
        $default_image = "projectdefault.png";
        $default_image_path = $file_dir . $default_image;

        if ($r_image == null or $r_image == '') {
            // Show default image if no image specified
            $r_image =  $default_image_path; 
        }

        /* No $r_image here because this file is in main folder
        else{
            $r_image = .$r_image;   
        } */


    ?>
                <div class='col-md-4'>
                    <div class='panel panel-default'>
                        
                        <div class='panel-heading'>
                            <h4><?php  echo $row1['projname']; ?></h4>
                            <h8> By <?php echo $row2['uname']; ?></h8>
                    
                        </div>
                        
                        <div class='panel-body'>

                        <!-- Showing Image of the project --> 
                            <div class='row' style='margin-top:-15px; margin-right:-15px; margin-left:-15px;'>
                                 <img src=<?php echo $r_image; ?> class='center-block img-rectangle img-responsive' style=' position: relative;
                                   height:200px;  width:100%; background-position: 50% 50%' />
                            </div>

                        <?php

                             $desc=str_pad($row1['projdescription'],50,' ');
                        ?>
                            
                        </div>
                            
                            <p> <?php echo substr($desc,0,50); ?> ....</p>
                <?php 
                    $fundstatus1=($row1['projfundcollected']/$row1['projmaxfundreq'])*100;
                            
                    $deadline1=date_create($row1['projfunddeadlinedatetime']);
                    $now1 = new DateTime();
                    $interval1 = $deadline1->diff($now1);
                      
                            //echo date_format($deadline,'g:ia \o\n jS F Y')
                              //<a href='project.php' class='btn btn-default'>Learn More</a></div>";
                ?>            
                        <div class='panel-footer'>Funding Deadline: <?php echo $interval1->format("%a days, %h hours"); ?>
                            <br>Funds collected: $<?php echo $row1['projfundcollected']; ?></br>

                            <br><h8>Funding Progress</h8></br>

                            <div class='progress'>
                                        <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style="width: <?php echo $fundstatus1."%"; ?> ">
                                            <span class='sr-only'></span><?php echo $row1['projstatus']; ?>
                                        </div>
                            </div>


                            <div class="row">
                                <!--
                                <div class="col-md-3 col-lg-3 ">
                                    <form action='../phplikes.php' method='POST'>
                                        <input type='hidden' name='projid' id='projid' value=<?php echo $row1['projid']; ?> />
                                        <button  name='setlikes' id='setlikes' value='submit' class='btn btn-default'>Like It? </button>
                                    </form>

                                </div> -->

                                
                                <!-- Request going to the Project page -->
                                <div class="col-md-3 col-lg-3"> 
                                    <form action='./projsearch/proj.php' method='GET'>
                                        <input type='hidden' name='projectid' id = 'projectid' value=<?php echo $row1['projid']; ?> />
                                        <button  name='getproject' id='getproject' value='submit' class='btn btn-danger'>See in Detail</button>
                                    </form>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
<?php   

    } // closing of while statement
} // Closing of if statement for row count
else{

?>

<div class="jumbotron">
    <h2>

        <div class="alert alert-danger">
            <strong>You Have not liked any projects!! </strong>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />


        </div> 
    </h2> 
     
</div>

<?php
}
?>

     

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
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

