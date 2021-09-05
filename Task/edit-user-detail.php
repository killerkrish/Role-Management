<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ccmsaid']==0)) {
  header('location:logout.php');
  } else{
    $roleid = $_SESSION['roleid'];
    $ret=mysqli_query($con,"select * from tblroles_permissions where role_id='$roleid'");
    $cnt=1;
    while ($perm=mysqli_fetch_array($ret)) {
        $premissions[] =$perm['perm_id'];
        $cnt=$cnt+1;
    }
    if(!in_array(7, $premissions)){
        echo '<script>alert("Permission Denied Please Contact Your Administrator for More Info.")</script>';
        echo "<script>window.location.href ='manage-newusers.php'</script>";
    }
    if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['ccmsaid'];
    $AName=$_POST['username'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  
     $query=mysqli_query($con, "update tbladmin set UserName='$AName', MobileNumber ='$mobno', Email= '$email' where ID='$adminid'");
    if ($query) {
    $msg="Profile has been updated.";
  }
  else
    {
      $msg="Something Went Wrong. Please try again.";
    }
  }
  ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    
    <title>Edit Profile</title>
   

    <link rel="apple-touch-icon" href="apple-icon.png">
   


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>



</head>

<body>
    <!-- Left Panel -->

    <?php include_once('includes/sidebar.php');?>

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php include_once('includes/header.php');?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Edit Profile</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="adminprofile.php">Edit Profile</a></li>
                            <li class="active">Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="row">
                    <div class="col-lg-6">
                       <!-- .card -->

                    </div>
                    <!--/.col-->

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Edit</strong><small> Profile</small></div>
                            <form name="profile" method="post" action="">
                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
                            <div class="card-body card-block">
 <?php
$id=$_GET['upid'];
$ret=mysqli_query($con,"select * from tbladmin where ID='$id'");

$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
$roleid = $row['RoleId'];

?>
                                <div class="form-group"><label for="company" class=" form-control-label">User Name</label><input type="text" name="username" value="<?php  echo $row['UserName'];?>" class="form-control" required='true'></div>
                                <?php  
                                  $res=mysqli_query($con,"select * from tblroles where role_id='$roleid'");
                                  while ($row1=mysqli_fetch_array($res)) {
                                    ?>
                                    <div class="form-group"><label for="vat" class=" form-control-label">Role</label><input type="text" name="role" value="<?php  echo $row1['role_name'];?>" class="form-control" readonly=""></div><?php }?>
                                        <div class="form-group"><label for="street" class=" form-control-label">Contact Number</label><input type="text" name="mobilenumber" value="<?php  echo $row['MobileNumber'];?>"  class="form-control" maxlength='10' required='true'></div>
                                            <div class="row form-group">
                                                <div class="col-12">
                                                    <div class="form-group"><label for="city" class=" form-control-label">Email</label><input type="email" name="email" value="<?php  echo $row['Email'];?>" class="form-control" required='true'></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group"><label for="postal-code" class=" form-control-label">Created Date</label><input type="text" name="" value="<?php  echo $row['AdminRegdate'];?>" readonly="" class="form-control"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                    <?php }?>
                                                     <div class="card-footer">
                                                       <p style="text-align: center;"><button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit">
                                                            <i class="fa fa-dot-circle-o"></i> Update
                                                        </button></p>
                                                        
                                                    </div>
                                                </div>
                                                </form>
                                            </div>



                                           
                                            </div>
                                        </div><!-- .animated -->
                                    </div><!-- .content -->
                                </div><!-- /#right-panel -->
                                <!-- Right Panel -->


                            <script src="vendors/jquery/dist/jquery.min.js"></script>
                            <script src="vendors/popper.js/dist/umd/popper.min.js"></script>

                            <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
                            <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script>

                            <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                            <script src="assets/js/main.js"></script>
</body>
</html>
<?php }  ?>