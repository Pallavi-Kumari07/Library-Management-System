<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
$status=$_GET['status'];
$days=$_GET['days'];
if(isset($_POST['return']))
{
$rid=intval($_GET['rid']);
$fine=$_POST['fine'];
$ISBNNumber=$_GET['ISBNNumber'];

$rstatus=1;
$sql="update tblissuedbookdetails set fine=:fine,ReturnStatus=:rstatus where id=:rid";
$query = $dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->bindParam(':fine',$fine,PDO::PARAM_STR);
$query->bindParam(':rstatus',$rstatus,PDO::PARAM_STR);
$query->execute();

$sql="update tblbooks set IssuedCopies=IssuedCopies-1 where ISBNNumber=:ISBNNumber";
$query = $dbh->prepare($sql);
$query->bindParam(':ISBNNumber',$ISBNNumber,PDO::PARAM_STR);
$query->execute();

$_SESSION['msg']="Book Returned successfully";
header('location:manage-issued-books.php');


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
    <title>Online Library Management System | Issued Book Details</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="style1.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-..." crossorigin="anonymous">
<script>
// function for get student name
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrap">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Issued Book Details</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
<div class="panel panel-info">
<div class="panel-heading">
Issued Book Details
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$rid=intval($_GET['rid']);
$sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.id,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.ReturnStatus from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblissuedbookdetails.id=:rid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   



<div class="form-group">
<label>Student Name :</label>
<?php echo htmlentities($result->FullName);?>
</div>

<div class="form-group">
<label>Book Name :</label>
<?php echo htmlentities($result->BookName);?>
</div>


<div class="form-group">
<label>Book ID :</label>
<?php echo htmlentities($result->id);?>
</div>

<div class="form-group">
<label>ISBN :</label>
<?php echo htmlentities($result->ISBNNumber);?>
</div>

<div class="form-group">
<label>Book Issued Date :</label>
<?php echo htmlentities($result->IssuesDate);?>
</div>

<div class="form-group">
<label>Book Returned Date :</label>
<?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {
                                            echo htmlentities($result->ReturnDate);
}?>
</div>

<div class="form-group">
<?php
$flag=0;
if(strpos($status,'exceeded')!== false && $result->ReturnDate===NULL)
{
$flag=1;
	?>
<span><b>Fine To Be Paid:</b><?php echo htmlentities($days*$_SESSION['fine']);?></span>
<?php
}?>
</div>


<?php if($flag===1){?>
<div class="form-group">
<label>Fine (in Rs) :</label>
<input class="form-control" type="text" name="fine" id="fine" />
<?php }
else {
?>
<div class="form-group">
<label>Fine (in Rs) :</label>
<?php
if($result->fine===Null){
echo htmlentities("0");
}
else
{
	echo htmlentities($result->fine);
}
}
?></div>
</div>

 <?php if($result->ReturnStatus==0){?>
<div class="form-group">
<div class="row">
<div class="col-sm-8" style="padding-left:20px;padding-top:-20px;">
<button type="submit" name="return" id="submit" class="btn btn-info">Return Book</button>
</div>
</div>
</div>
<br>
 </div>

<?php }}}?>
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
