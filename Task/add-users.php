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
    if(!in_array(6, $premissions)){
        echo '<script>alert("Permission Denied Please Contact Your Administrator for More Info.")</script>';
        echo "<script>window.location.href ='dashboard.php'</script>";
    }
    if(isset($_POST['submit']))
  {

$cmsaid=$_SESSION['ccmsaid'];
$username=$_POST['username'];
$pass=$_POST['pass'];
$roleid=$_POST['rolename'];
$mobilenumber=$_POST['mobilenumber'];
$email=$_POST['email'];

$query=mysqli_query($con,"insert into tbladmin(RoleId,UserName,MobileNumber,Email,Password) value('$roleid','$username','$mobilenumber','$email','$pass')") or die(mysqli_error($con));
if ($query) {
echo '<script>alert("User has been added.")</script>';
echo "<script>window.location.href ='add-users.php'</script>";

}
else
{
echo '<script>alert("Something Went Wrong. Please try again.")</script>';       
}
  
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    
    <title>User Add</title>
    

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
                        <h1>User</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="add-users.php">User</a></li>
                            <li class="active">Add</li>
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
                            <div class="card-header"><strong>User</strong></div>
                            <form name="computer" method="post" action="">
                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
                            <div class="card-body card-block">
 
                                <div class="form-group"><label for="company" class=" form-control-label">User Name</label><input type="text" name="username" value="" class="form-control" id="username" required="true"></div>
                                                                          
                                            <div class="row form-group">
                                                <div class="col-12">
                                                    <div class="form-group"><label for="city" class=" form-control-label">Mobile Number</label><input type="text" name="mobilenumber" id="mobilenumber" value="" class="form-control" required="true" maxlength="10" pattern="[0-9]+"></div>
                                                    </div><div class="col-12">
                                                    <div class="form-group"><label for="city" class=" form-control-label">Password</label><input type="text" name="pass" id="pass" value="" class="form-control" required="true"></div></div>
                                                    <div class="col-12">
                                                    <div class="form-group"><label for="city" class=" form-control-label">Email</label><input type="email" name="email" id="email" value="" class="form-control" required="true"></div>
                                                    </div>
                                                    <div class="col-12">
                                                    <div class="form-group"><label for="city" class=" form-control-label">Role</label><select type="text" name="rolename" id="rolename" value="" class="form-control" required="true">
                                                    <option value="">Choose Role</option>
                                <?php $query=mysqli_query($con,"select * from  tblroles");
              while($row=mysqli_fetch_array($query))
              {
              ?>    
              <option name='rolename' value="<?php echo $row['role_id'];?>"><?php echo $row['role_name'];?></option>
                  <?php } ?>  
                                                    </select></div>
                                                    </div>
                                                
                                                    </div>
                                                    
                                                    </div>
                                                    
                                                     <div class="card-footer">
                                                       <p style="text-align: center;"><button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit">
                                                            <i class="fa fa-dot-circle-o"></i>  Add
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