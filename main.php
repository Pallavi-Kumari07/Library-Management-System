<?php
//http://localhost/se_project/Library-Management-System/main.php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
$_SESSION['login']='';
}
if(isset($_POST['login']))
{
$email=$_POST['emailid'];
$password=$_POST['password'];
$sql ="SELECT * FROM tblstudents WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() == 0) {
    echo "<script>alert('Email does not exist');</script>";
}

if($query->rowCount() > 0)
{
 foreach ($results as $result) {
 $_SESSION['stdid']=$result->StudentId;
 $_SESSION['username']=$result->FullName;
if($result->Status==1)
{
$_SESSION['login']=$_POST['emailid'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else {
echo "<script>alert('Your Account Has been blocked .Please contact admin');</script>";
}}} 

else{
echo "<script>alert('Invalid Details');</script>";
}}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Online Library Management System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php');
	  include('bgwork.php');?>
<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
    <header>
        <div class="header-content">
            <div class="logo-container">
                <div class="logo-text">LIBRARY</div>
            </div>
            <div class="nav-buttons">
                <button class="nav-btn">Book Catalog</button>
                <button class="nav-btn">Study Spaces</button>
                <button class="nav-btn">Resources</button>
                <button class="nav-btn">Authors</button>
            </div>
        </div>
    </header>
    
    <div class="content">
        <div class="overlay"></div>
        <div class="content-text">
            <div class="welcome-card">
                <h1>Welcome to Library</h1>
                <p>Your gateway to knowledge resources and seamless navigation</p>
                <div class="feature-buttons">
                    <button class="feature-btn">Find Books</button>
                    <button class="feature-btn">Library Map</button>
                    <button class="feature-btn">Issue/Return</button>
                </div>
            </div>
        </div>
    </div>
    
    <section class="library-map-section">
        <h2>Library Navigation Map</h2>
        <p>Locate resources easily with our interactive map</p>
        
        <div class="map-container">
            <div class="map-legend">
                <div class="legend-item"><span class="color-box tech-box"></span> Technology Section</div>
                <div class="legend-item"><span class="color-box science-box"></span> Science Section</div>
                <div class="legend-item"><span class="color-box humanities-box"></span> Humanities</div>
                <div class="legend-item"><span class="color-box reference-box"></span> Reference</div>
                <div class="legend-item"><span class="color-box study-box"></span> Study Areas</div>
            </div>
            
            <div class="map-image">
                <!-- Placeholder for actual map -->
                <div class="library-layout">
                    <div class="section tech-section">Technology Books</div>
                    <div class="section science-section">Science Books</div>
                    <div class="section humanities-section">Humanities</div>
                    <div class="section reference-section">Reference</div>
                    <div class="section study-area">Study Area</div>
                    <div class="section issue-desk">Issue Desk</div>
                    <div class="section entrance">Entrance</div>
                </div>
            </div>
        </div>
    </section>
    <br><br><br>
    <section>
    <div class="row">

              <div class="col-md-10 col-sm-8 col-xs-12 col-md-offset-1">
                    <div id="carousel-example" class="carousel slide slide-bdr" data-ride="carousel" >
                   
                    <div class="carousel-inner">
                        <div class="item active">

                            <img src="assets/img/1.jpg" alt="" />
                           
                        </div>
                        <div class="item">
                            <img src="assets/img/2.jpg" alt="" />
                          
                        </div>
                        <div class="item">
                            <img src="assets/img/3.jpg" alt="" />
                           
                        </div>
                    </div>
                    <!--INDICATORS-->
                     <ol class="carousel-indicators">
                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example" data-slide-to="1"></li>
                        <li data-target="#carousel-example" data-slide-to="2"></li>
                    </ol>
                    <!--PREVIUS-NEXT BUTTONS-->
                     <a class="left carousel-control" href="#carousel-example" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a></div></div>
  </section>
  
    <section class="library-features">
        <h4>---</h4>
        <h2>Library Management System</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Book Search</h3>
                <p>Find books by title, author, subject or ISBN</p>
            </div>
            <div class="feature-card">
                <h3>Issue/Return</h3>
                <p>Manage your borrowed books and due dates</p>
            </div>
            <div class="feature-card">
                <h3>Reservations</h3>
                <p>Reserve books or study spaces in advance</p>
            </div>
            <div class="feature-card">
                <h3>Digital Resources</h3>
                <p>Access e-books, journals and research papers</p>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-content">
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