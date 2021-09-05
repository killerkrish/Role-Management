<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ccmsaid']==0)) {
    header('location:logout.php');
} else{
    if(isset($_POST['submit']))
    {
        $roleid=$_GET['editid'];
        $cmsaid=$_SESSION['ccmsaid'];
        $rolename=$_POST['rolename'];
        $roleperms=$_POST['roleperm'];
        $query=mysqli_query($con,"update tblroles set role_name ='$rolename' where role_id='$roleid'") or die(mysqli_error($con));

        $query=mysqli_query($con,"delete from tblroles_permissions where role_id='$roleid'") or die(mysqli_error($con));

        foreach($roleperms as $roleperm) {

            $permmod=mysqli_query($con,"select perm_mod from tblpermissions where  perm_id='$roleperm'") or die(mysqli_error($con));
                $cnt=1;
                while($row=mysqli_fetch_array($permmod))
                {
                    $permmod = $row["perm_mod"];
                    $query1 = "insert into tblroles_permissions(role_id, perm_mod, perm_id) values ('$roleid', '$permmod', '$roleperm')";
                    $query=mysqli_query($con, $query1) or die(mysqli_error($con)); 
                    $cnt=$cnt+1;
                }
        }
        
if ($query) {
    $msg="Role has been update.";
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
    }

  
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
   
    <title>Update Role</title>
  
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
                        <h1>Update Role</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="manage-computer.php">Role</a></li>
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
                            <div class="card-header"><strong>Role</strong></div>
                            <form name="package" method="post" action="">
                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
                            <div class="card-body card-block">
 <?php
 $rid=$_GET['editid'];
$ret=mysqli_query($con,"select role_name from tblroles where role_id='$rid'") or die(mysqli_error($con));
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
?>
                            <div class="card-body card-block">
 
                                <div class="form-group"><label for="company" class=" form-control-label">Role Name</label>
                                    <input type="text" name="rolename" value="<?php  echo $row['role_name'];?>" class="form-control" id="rolename" required="true"></div><?php } ?> 
                                                    <div class="form-group"><label for="city" class=" form-control-label">Role Permissions</label><br>

                                <?php
                                    $rid=$_GET['editid'];
                                    $res=mysqli_query($con,"select tblroles_permissions.perm_id as prem, tblpermissions.perm_id, tblpermissions.perm_desc from tblpermissions inner join tblroles_permissions on tblroles_permissions.perm_id = tblpermissions.perm_id where tblroles_permissions.role_id = '$rid'") or die(mysqli_error($con));
                                    $ret=mysqli_query($con,"select * from tblpermissions") or die(mysqli_error($con));
                                    $cnt=1;
                                    while ($row=mysqli_fetch_array($res)) { 
                                        $selected[] = $row['perm_id'];
                                    }
                                    while ($row1=mysqli_fetch_array($ret)) { ?>
                                            <input type="checkbox" name="roleperm[]" id="roleperm" value="<?php echo $row1['perm_id'];?>" 
                                            <?php 
                                                if(in_array($row1['perm_id'],$selected)) 
                                                    {echo "checked";}?>>
                                            <?php echo $row1['perm_desc'];
                                    } ?><br>
                                    </div>
                                </div>
                                                    
                                                    
                                                     <div class="card-footer">
                                                       <p style="text-align: center;"><button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit">
                                                            <i class="fa fa-dot-circle-o"></i>  Update
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