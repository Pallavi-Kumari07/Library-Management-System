<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$fine=$_POST['finetf'];

$sql ="SELECT fine from tblfine ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listedbooks=$query->rowCount();
if($listedbooks==0)
{
$sql="insert into tblfine values(:fine)";
$query = $dbh->prepare($sql);
$query->bindParam(':fine',$fine,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
}
else
{	
$sql="update tblfine set fine=:fine where 1";
$query = $dbh->prepare($sql);
$query->bindParam(':fine',$fine,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
}

if($lastInsertId)
{
$_SESSION['msg']="Fine Updated successfully";
header('location:set-fine.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:set-fine.php');
}

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Add Author</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-..." crossorigin="anonymous">

</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrap">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Set Fine</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<div class="panel panel-info">
<div class="panel-heading">
Fine Update Section
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Fine Per Day</label>
<input class="form-control" type="text" name="finetf" autocomplete="off"  required />
</div>

<button type="submit" name="update" class="btn btn-info">Update </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
    <footer>
        <div class="footer-content foot">
            <div>&copy; 2025 NSUT Library | All Rights Reserved</div>
            <div class="footer-links">
                <a href="#">Library Hours</a>
                <a href="#">Contact Librarian</a>
                <a href="#">Help & FAQs</a>
            </div>
        </div>
    </footer>
    
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
