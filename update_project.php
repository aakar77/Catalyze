<!-- This is the Dashboard for seeing projects You Have Sponsored --> 

<?php

session_start();
if(isset($_SESSION['uid']))
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

    <title>Catalyze</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <link href="css/validnstyle.css" rel="stylesheet">

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
                    <li class="active">
                        <a href="dashboard2.php"><i class="fa fa-fw fa-plus"></i>Create New Project</a>
                    </li>
                    <li>
                        <a href="dashboard3.php"><i class="fa fa-fw fa-share"></i>Your Sponsored Projects</a>
                    </li>
                    <li>
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

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           <i class="fa fa-plus"></i>Create New Project<!-- <small>Projects Overview</small> -->
                        </h1>
                        <!--
                        <ol class="breadcrumb">
                            <li class="active">
                                 Projects Created
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->

<?php 

    require './php/connectdb.php';

    $c_uid = $_SESSION['uid'];
    $c_projid = $_GET['projectid'];


    $sql1="Select * from project where projcreatorid =".$c_uid." AND projid=".$c_projid;

    $fetch1=mysqli_query($con,$sql1);
    $row1=mysqli_fetch_array($fetch1);

    

    ?>
    
<!--    maid    projid  updatedatetime  mediauri    mtypeid mcaption -->

    <div class="row centered-form">
                <div class="col-md-8 col-md-offset-2">
                    <!-- -->
                    <div class="panel panel-default">
                        <!-- Panel class starts -->
                        <div class="panel-heading">
                            <!-- For Heading of the panel -->
                            <h3 class="panel-title">Update Project: <?php echo $row1['projname']; ?></h3>
                        </div>
                        <!--Panel heading ends -->
                        <div class="panel-body">
                            <!-- Panel body class starts -->

                            <!-- HTML FORM BEGINS -->

                            <form name="updateform" id="updateform" method="post" enctype='multipart/form-data' action="./php/updateproject.php" novalidate>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><span class="star">* Fields are required.</span></p>
                                    </div>
                                </div>
                                        <input type='hidden' name='projectid' id = 'projectid' value=<?php echo $row1['projid']; ?> />


                                <!-- Row for Project Update Description begins -->
                                    <div class="form-group">
                                        <label for="updatedescription">Update Description<span class="star">*</span></label>
                                        <textarea type="text" name="updatedescription" id="updatedescription" class="form-control input-sm" placeholder="Please Enter Project Details" required autofocus> </textarea>
                                    </div>
                                <!-- Row for Project Update Description ends --> 

                

                                <!-- Project Update Image starts Optional-->
                                <div class="form-group">
                                    <label for="profilePic" class="control-label">Please choose your Project Update Image</label>
                                    <input type="file" name="profilePic" id="profilePic" accept="image/gif,image/jpeg,image/png,image/jpg"  placeholder="Please choose your Project Update Image" />
                                </div>
                                <!-- Project Update Image Image ends -->

<!--.mp3,audio -->

                                <!-- Project Update Mp3 starts Optional-->
                                <div class="form-group">
                                    <label for="profileAudio" class="control-label">Please choose your Project Update Audio</label>
                                    <input type="file" name="profileAudio" id="profileAudio" accept=".mp3"  placeholder="Please choose your Project Update audio file" />
                                </div>
                                <!-- Project Update Mp3 ends -->


                                <!-- Project Update Mp3 starts Optional-->
                                <div class="form-group">
                                    <label for="profileVideo" class="control-label">Please choose your Project Update Video</label>
                                    <input type="file" name="profileVideo" id="profileVideo" accept=".mp4"  placeholder="Please choose your Project Update Video file" />
                                </div>
                                <!-- Project Update Mp3 ends -->


                                <!-- Submit and reset buttons starts -->
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <input type="submit" name="submit" id="submit" value="Update Project" class="btn btn-primary btn-block" />
                                        </div>
                                        <div class="col-md-6">
                                            <input type="reset" name="reset" id="reset" value="Reset" class="btn btn-default btn-block" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit and reset buttons ends -->

                            </form>
                            <!-- Form ends -->

                        </div>

                    </div>
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
    
    <!-- For Bootstrap JavaScript Datetime -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Jquery validation file -->
        <script src="js/jquery.validate.js" type="text/javascript"></script>


    <script type="text/javascript">


    var jqueryValidator;
    
    $(document).ready(function() {
        jqueryValidator = $("#updateform").validate({
            rules : {
                updatedescription: {
                    required : true,
                    minlength: 50,
                    maxlength: 300
                },

                profilePic : {
                    accept : "png|jpe?g|gif"
                    //filesize : 1048576
                } /*
                profileAudio : {
                    accept : "mp3"
                   // filesize : 10485760,
                 
                },
                profileVideo : {
                    accept : "mp4"
                  //  filesize : 52428800,
                } */

            },
            
            messages : {

                updatedescription: {
                    required : "Please enter proper meaningful description",
                    minlength: "Please provide meaningful project description",
                    maxlength: "Can't exceed minimum length of 300 characters"
                },
                profilePic : {
                    accept : "Only Image type files accepted, jpe, png, jpeg only"
                }
                /*
                profileAudio : {

                    accept : "Only .mp3 type files accepted"
                //    filesize : "Please provide proper file size"
                    
                },
                profileVideo : {

                    accept : "Only video files accepted"
                 //   filesize : "Please provide proper file size"
                    
                } */
            },
            errorElement : "div",
        });
    });



    </script>

</body>

</html>
<?php 


}
else {
    header("Location: ./index.php");

}

?>

