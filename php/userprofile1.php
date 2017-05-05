<?php
//Session Checking 
 
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

    <title>CATALYZE-Project</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

   <!--
    <link href="../css/user_profile.css" rel="stylesheet"> -->

    <!-- Theme CSS -->
    <link href="../css/agency.min.css" rel="stylesheet">

    </head>

<body id="page-top" class="index">

    <!-- Navigation -->
 <!-- Page Content -->
<div class="container">


    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a class="navbar-brand" href="index.html">Catalize</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling --> 
             <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="../dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#UserProfile">User Profile</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#CreatedProjects">Projects Created</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#SponsoredProjects">Projects Supported</a>
                    </li>
                </ul>
            </div> 

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!--project top page change-->

<?php

//Will be replaced by user session

if(isset($_GET['userid'])){

    $user_session = $_SESSION['uid'];
    $c_uid = $_GET['userid'];
    require './connectdb.php';
    require './sanitize.php';

    // Sanitize custom function present in the file which contains necessary functions
    $c_uid = sanitize_input($c_uid, $con);

    //Quick guide for user table uid uname uemail upassword uhometown ucontactno image
    //Query for getting User Profilee page information

    //Selecting a single row!
    $sql = "select u.uid, u.uname, u.uemail, u.uhometown, u.image FROM USER u WHERE u.uid = ?";
    
    // Default User file if not provided
    $file_dir = "../uploads/user/";
    $default_image = "userdefault.jpg";
    $default_image_path = $file_dir . $default_image;





    if($stmt = $con->prepare($sql)){

        $stmt->bind_param('i', $c_uid);

        if($stmt->execute() ) 
        {

            $stmt->store_result();

            if($stmt->num_rows == 1){

                  //echo "Success";

                $r_uid = "";
                $r_uname = "";
                $r_uemail = "";
                $r_uhometown = "";
                $r_image = "";

                $stmt->bind_result($r_uid, $r_uname, $r_uemail,$r_uhometown,$r_image);

                while ($stmt->fetch())
                {


                    if ($r_image == null or $r_image == '') {
                        // Show default image if no image specified
                        $r_image =  $default_image_path; 
                     }


                        // For calculating no of followers
                        $sql2 = "SELECT COUNT(*) AS noOfFollowers FROM follows f WHERE f.followsid = ?";
                        $stmt2 = $con->prepare($sql2);
                        $stmt2->bind_param('i',$c_uid);
                        $stmt2->execute();
                        $stmt2->store_result();
                        $noOfFollowers = 0;
                        $stmt2->bind_result($noOfFollowers);
                        $stmt2->fetch();

                        // For calculating no of Projects Created
                        $sql3 = "SELECT COUNT(*) AS noCProjects FROM project p WHERE p.projcreatorid = ?";
                        $stmt3 = $con->prepare($sql3);
                        $stmt3->bind_param('i',$c_uid);
                        $stmt3->execute();
                        $stmt3->store_result();
                        $noOfCProjects = 0;
                        $stmt3->bind_result($noOfCProjects);
                        $stmt3->fetch();

                        // For calculating no of Projects Backed / Sponsored
                        $sql4 = "SELECT COUNT(DISTINCT s.projid) AS noSProjects  FROM sponsor s WHERE s.uid = ?";
                        $stmt4 = $con->prepare($sql4);
                        $stmt4->bind_param('i',$c_uid);
                        $stmt4->execute();
                        $stmt4->store_result();
                        $noCProjects = '';
                        $stmt4->bind_result($noSProjects);
                        $stmt4->fetch();



                        $already_followed = 0;

    // For Checking whether the given user is already followed or not ..
                        $sql5 = "select * FROM follows f where f.followsid=".$r_uid." and f.uid=".$user_session;
                        
                        $fetch5=mysqli_query($con,$sql5);
                        $row_cnt = mysqli_num_rows($fetch5);

                        if($row_cnt != 0){
                            $already_followed = 1;
                        }
                        
                        



?>
    <div class="container" style="margin-top: 100px;">


        <section id='UserProfile' class='bg-light-gray' style='padding-bottom: 50px; padding-top: 0px;'>

            <div class="container">

                 <div class='row'>
                    <div class='col-lg-12'>
                        <h3 class='page-header'>User Profile</h3>
                    </div>
                </div>



                <div class="row">
                    <div class="col-xs-8 col-md-8 col-xs-12">

                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="row">

                                        <div class="col-xs-12 col-sm-8">
                                            <h1><strong><?php echo $r_uname;   ?></strong></h1>
                                            <h3><strong><?php echo $r_uemail; ?></strong></h3>
                                            <h3><strong><?php echo $r_uhometown; ?></strong></h3>
                                        </div><!--/col-->

                                        <div class="col-xs-12 col-sm-4 text-center">
                                            <br />
                                             <img src=<?php echo $r_image; ?> class='center-block img-circle img-responsive' style=" height: 150px;border-radius: 47%;" />

                                        </div><!--/col-->
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                
                                <!-- row close -->
                                <div>

<?php 


                    if($user_session == $r_uid){


                                echo "<div class='col-xs-12 col-sm-3'>
                                        <forrm>
                                          <button  name='addcard' id='addcard' class='btn btn-danger btn-block'>Add Card 
                                            </button>
                                        </form>
                                    </div><!--/col--> ";



                        }else{


                    
                            echo " <div class='col-xs-12 col-sm-3'>
                                <h2 id='nofcount' style='color:#b92b27;'><strong>".$noOfFollowers."
                                    </strong></h2>
                                <p>Followers</p>";       

                            if ($already_followed == 0){

                                echo "<button  name='follow' id='follow' class='btn btn-danger btn-block'>Follow? 
                                    </button>
                                     </div><!--/col-->";

                            }
                            else{

                                echo "<button  name='followed' id='followed' class='btn btn-danger btn-block' disabled>Followed ".$row_cnt."
                                    </button>
                                       
                                    </div><!--/col-->";


                            }


                    }                                
                                

          
                $stmt2->free_result(); 
                $stmt2->close(); 
            ?>
                            <div class="col-xs-12 col-sm-3">
                                        <h2 style="color:#286090;"><strong><?php echo $noOfCProjects; $stmt3->free_result(); $stmt3->close(); ?></strong></h2>
                                        <p>No of Projects Created</p>
                                        <a href="#CreatedProjects"  style="a:link, a:visited {

    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
},

a:hover, a:active {
    background-color: red;
}"><button class="btn btn-info btn-block" href="#">View Projects</button></a>
                                </div><!--/col-->


                                <div class="col-xs-12 col-sm-3">
                                        <h2 style="color:#007e33"><strong><?php echo $noSProjects; $stmt4->free_result(); $stmt4->close(); ?></strong></h2>
                                        <p>No of Projects Backed</p>
                                        <button class="btn btn-success btn-block" action="#SponsoredProjects"><span class="fa fa-user"></span>Hello</button>
                                </div><!--/col-->

                                </div><!--/row-->

                            </div><!--/panel-body-->
                        </div><!--/panel-->
                    </div>
                </div>
            </div>


            <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header" style = "background-color: #2a4d6b;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p id="modal-message">Some text in the modal.</p>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
              
            </div>
          </div>



        </section>


        <section id='CreatedProjects' class='bg-light-gray'>
            <div class='container'>
                
                <!--<div class='row'>-->
                    <div class='col-lg-12'>
                        <h3 class='page-header'>Created Projects</h3>
                    </div>
            


<?php 

    // $r_uid is the username fetched from above query  

    $sql1="Select * from project where projcreatorid=".$r_uid;
    $fetch1=mysqli_query($con,$sql1);

    while($row1=mysqli_fetch_array($fetch1))
    {
        // Fetching the user name and user ID
        /*
        $sql2="Select u.uname from user u, project p where u.uid=".$row1['projcreatorid'];
        $fetch2=mysqli_query($con,$sql2);
        $row2=mysqli_fetch_array($fetch2);
*/
        // For showing project image
        $r_image = $row1['projcoverimage'];

        $file_dir = "../uploads/projectcover/";
        $default_image = "projectdefault.png";
        $default_image_path = $file_dir . $default_image;

        if ($r_image == null or $r_image == '') {
            // Show default image if no image specified
            $r_image = ".".$default_image_path; 
        }

        //No $r_image here because this file is in main folder
        else{
            $r_image = ".".$r_image;   
        } 


    ?>

                <div class='col-md-4'>
                    <div class='panel panel-default'>
                        
                        <div class='panel-heading'>
                            <h4><?php  echo $row1['projname']; ?></h4>
                    
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
                        <div class='panel-footer'> Funding Deadline: <?php echo $interval1->format("%a days, %h hours"); ?>
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
                                    <form action='../projsearch/proj.php' method='GET'>
                                        <input type='hidden' name='projectid' id = 'projectid' value=<?php echo $row1['projid']; ?> />
                                        <button  name='getproject' id='getproject' value='submit' class='btn btn-danger'>See in Detail</button>
                                    </form>
                                </div>
                            </div> <!-- Row Close -->

                       </div>
                    </div>
                </div>
<?php   

}
?>

<?php
                } // While Closed
                $stmt->free_result();

            } // If Number of rows != 1 Closed
            else{
                // If no of rows != 1


            }
        } // if for stmt->execute()
        else{
            // stmt->execute() failed to close

        }

    } // if for $stmt = $con->prepare closed
    else{
        // Failed to prepare the statement

    }

    $stmt->close();


?>







            </div> <!-- container Close -->


        <section id='SponsoredProjects' class='bg-light-gray'>

        </section>

    </div>



        <!-- jQuery -->
        <script src="../js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" integrity="sha384-mE6eXfrb8jxl0rzJDBRanYqgBxtJ6Unn4/1F7q4xRRyIw7Vdg9jP4ycT7x1iVsgb" crossorigin="anonymous"></script>

        <!-- Contact Form JavaScript -->
        <script src="../js/jqBootstrapValidation.js"></script>

        <script type="text/javascript">
            // This script is for follow function


            $('#follow').click(function() {
            
                var userid = <?php echo $r_uid; ?>;   
                var followsid = <?php echo $user_session; ?>;
                            
              
               // var followerid = $('#followerid').val();
               // var userid = $('#userid').val();

                $.ajax({
                    url: './followuser.php',
                    type: 'POST',
                    data: {'userid': userid, 'followsid':followsid },
                    dataType: 'json',
                    success: function(data){
                    //alert("yes");
                        if(data.status == "success"){

                            var nof = $( "#nofcount" ).text()
                            nof = parseInt(nof) + 1;

                            $("#follow").prop("disabled",true);
                            $("#nofcount" ).text(nof);


                           $('#modal-message').html("Successfully Followed");
                           $('#myModal').modal({
                                show: 'true'
                            });

                        }
                        else if (data.status == "error"){

                           $("#follow").prop("disabled",true);
                           $('#modal-message').html("Sorry! You have already followed");
                           $('#myModal').modal({
                                show: 'true'
                            });
                            
                        }
                    },
                    error: function(xhr, desc, err){
                        console.log(xhr);
                        console.log("Details"+err);
                    }
                }); // ending ajax call
            });

            </script>

    </body>

    </html>


<?php

    } // Userid not set in Post
    else{
        // failed to get the userid via post
        
    }
} // Session close
else{
    header("Location: ../index.php");
}


?>
