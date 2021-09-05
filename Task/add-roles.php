<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ccmsaid']==0)) {
    header('location:logout.php');
} else{
    $roleid = $_SESSION['roleid'];
    $ret=mysqli_query($con,"select * from tblroles where role_id='$roleid'");
    $cnt=1;
    while ($perm=mysqli_fetch_array($ret)) {

        if($perm['role_name']!='Administrator'){
            echo '<script>alert("Permission Denied Please Contact Your Administrator for More Info.")</script>';
            echo "<script>window.location.href ='dashboard.php'</script>";
        }

        $cnt=$cnt+1;
    }
    if(isset($_POST['submit']))
    {
        $cmsaid=$_SESSION['ccmsaid'];
        $rolename=$_POST['rolename'];
        $roleperms=$_POST['roleperm'];
        $query=mysqli_query($con,"insert into tblroles(role_name) values ('$rolename')") or die(mysqli_error($con));
        $roleID=mysqli_query($con,"select role_id from tblroles where role_name='$rolename'") or die(mysqli_error($con));

        while($row=mysqli_fetch_array($roleID))
        {
            $roleid = $row["role_id"];
            foreach($roleperms as $roleperm) {
                $permmod=mysqli_query($con,"select perm_mod from tblpermissions where perm_id='$roleperm'") or die(mysqli_error($con));
                while($row=mysqli_fetch_array($permmod))
                {
                    $permmod = $row["perm_mod"];
                    $query = "insert into tblroles_permissions(role_id, perm_mod, perm_id) values ('$roleid', '$permmod', '$roleperm')";
                }
                $query=mysqli_query($con, $query) or die(mysqli_error($con)); 
            }
        }
        if ($query) {
            echo '<script>alert("Role has been added.")</script>';
            echo "<script>window.location.href ='add-roles.php'</script>";
        }
        else
        {
             echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
   
    <title>Add Roles</title>
  

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
                        <h1>Role</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="add-computer.php">Role</a></li>
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
                            <div class="card-header"><strong>Role</strong></div>
                            <form name="computer" method="post" action="">
                                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
                            <div class="card-body card-block">
 
                                <div class="form-group"><label for="company" class=" form-control-label">Role Name</label><input type="text" name="rolename" value="" class="form-control" id="rolename" required="true"></div>
                                                    <div class="form-group"><label for="city" class=" form-control-label">Role Permissions</label><br>

                                <?php $query=mysqli_query($con,"select * from  tblpermissions");
                                    while($row=mysqli_fetch_array($query))
                                    {
                                    ?>
                                    <input type="hidden" name="permmode[]" value="<?php echo $row['perm_mode'];?>" style = "width: 10%;height: 13px;" id="permmode">   
                                    <input type="checkbox" name="roleperm[]" value="<?php echo $row['perm_id'];?>" style = "width: 10%;height: 13px;" id="roleperm"><?php echo $row['perm_desc'];?><br>
                                    <?php } ?>  
                                                    </select></div>
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