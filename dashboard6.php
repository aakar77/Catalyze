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
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>


            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
           <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i>Your Projects</a>
                    </li>
                    <li>
                        <a href="dashboard2.php"><i class="fa fa-fw fa-plus"></i>Create New Project</a>
                    </li>
                    <li>
                        <a href="dashboard3.php"><i class="fa fa-fw fa-share"></i>Your Sponsored Projects</a>
                    </li>
                    <li>
                        <a href="dashboard4.php"><i class="fa fa-fw fa-heart"></i>Project's Liked</a>
                    </li>
                    <li class="active">
                        <a href="dashboard5.php"><i class="fa fa-fw fa-arrow-right"></i>User's Followed</a>
                    </li>
                    <li>
                        <a href="dashboard6.php"><i class="fa fa-fw fa-arrow-left"></i>User's Following</a>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i>Search a Projects</a>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-edit"></i>Update Project</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

<?php 
    require './php/connectdb.php';

    $c_uid = $_SESSION['uid'];
  //  "Select * from user u where u.uid in (SELECT f.followsid from follows f where f.uid=".$c_uid.")"


    $sql="Select COUNT(*) AS noOfFollowers FROM follows f WHERE f.uid=".$c_uid;

    $fetch=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($fetch);

    $noOfFollowers= $row['noOfFollowers'];

    if ($noOfFollowers == null){
        $noOfFollowers = 0;
    }

?>


     <div id="page-wrapper" style=".fill { min-height: 100%; height: 100%; }">

            <div class="container-fluid" style=".fill { min-height: 100%; height: 100%; }">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <h1 class="page-header">
                           <i class="fa fa-arrow-left"></i>Your Followers <!-- <small>Projects Overview</small> -->
                        </h1>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h1 class="page-header">
                            <i class="fa fa-unchecked"></i>No. of Followers : <?php echo $noOfFollowers; ?>
                        </h1> 
                    </div>
                </div>
                <!-- /.row -->

<?php

    $sql1="Select * from user u where u.uid in (SELECT f.followsid from follows f where f.uid=".$c_uid.")";  

    $fetch1=mysqli_query($con,$sql1);

    while($row1=mysqli_fetch_array($fetch1))
    {
        
        // For showing project image
        $r_image = $row1['image'];

        $file_dir = "./uploads/user/";
        $default_image = "userdefault.jpg";
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
                <div class='col-md-3'>
                    <div class='panel panel-default'>
                        
                        <div class='panel-heading'>
                            <h4><?php  echo $row1['uname']; ?></h4>                    
                        </div>
                        
                        <div class='panel-body'>

                        <!-- Showing Image of User --> 
                            <div class='row' style='margin-top:-15px; margin-right:-15px; margin-left:-15px;'>
                                 <img src=<?php echo $r_image; ?> class='center-block img-rectangle img-responsive' style=' position: relative;
                                   height:150px;  width:100%; background-position: 50% 50%' />
                            </div> 
                        </div>
                            
                <?php 
                   
                      
                            //echo date_format($deadline,'g:ia \o\n jS F Y')
                              //<a href='project.php' class='btn btn-default'>Learn More</a></div>";
                ?>            
                        <div class='panel-footer'>
                            <div class="row">    
                                <!-- Request going to the User Profile Page -->
                                <div class="col-md-3 col-lg-3"> 
                                    <form action='./php/userprofile1.php' method='POST'>
                                        <input type='hidden' name='userid' id='userid' value=<?php echo $row1['uid']; ?> />
                                        <button  name='getproject' id='getproject' value='submit' class='btn btn-danger'>See <?php echo $row1['uname']; ?>'s Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div> 
                        <!-- Closing panel-footer -->
                    </div>
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

