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
    if(!in_array(5, $premissions)){
        echo '<script>alert("Permission Denied Please Contact Your Administrator for More Info.")</script>';
        echo "<script>window.location.href ='dashboard.php'</script>";
    }
   
// Handle delete
if (isset($_GET['delete_id'])) {
    if(!in_array(8, $premissions)){
        echo '<script>alert("Permission Denied Please Contact Your Administrator for More Info.")</script>';
        echo "<script>window.location.href ='manage-newusers.php'</script>";
    }else{
        echo $_GET['delete_id'];

        $delete_id = (int) $_GET['delete_id'];

        $sql="DELETE FROM tbladmin WHERE ID='$delete_id'";
        $result=mysqli_query($con, $sql) or die(mysqli_error($con));

        if ($result) {
            echo '<script>alert("Deleted Sucessfully.")</script>';
            echo "<script>window.location.href ='manage-newusers.php'</script>";
        }
        else
        {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
}

  ?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    
    <title>CCMS New Users</title>
   

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
                        <h1>New Users</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="manage-newusers.php">New Users</a></li>
                            <li class="active">New Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">New Users</strong>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <tr>
                  <th>S.NO</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Mobile Number</th>
                 <th>Action</th>
                </tr>
                                        </tr>
                                        </thead>
                                    <?php
$ret=mysqli_query($con,"select *from tbladmin");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
              
                <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php  echo $row['UserName'];?></td>
                  <td><?php  echo $row['Email'];?></td>
                  <td><?php  echo $row['MobileNumber'];?></td>
                 
                  <td ><a href="edit-user-detail.php?upid=<?php echo $row['ID'];?>">Update</a> | <a href="?delete_id=<?php echo $row['ID']?>">Delete</a></td>
                </tr>
                <?php 
$cnt=$cnt+1;
}?>

                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>

</html>
<?php }  ?>