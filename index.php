<?php
/**
 * * @file
 * php version 8.2
 * Index Page for CMS
 * 
 * @category CMS
 * @package  Index_Landing_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/index.php
 */
require_once "icludes/session.php";
ini_set("display_errors", "On");
require "includes/db_conn.php" ;
require_once "includes/functions.php";
require "includes/date_time.php";

$database = new Database("localhost", "root", "root", "API_ToDo_List");
$database->conn();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="BooBoo">
<meta http-equiv="X-UA-Compatible" content="IE-edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>STCMediaBlog CMS System</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="javascript/js_script.js"></script>
</head>
<!-----------------------------------BODY BEGIN------------------------------------>
<body style="background-color:#e3e8e4;">
<!-------------------------------------NAV-BAR------------------------------------->
<div style="height: 10px;background-color: #f4f4f4;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
<div class="container">
<a href="index.php" class="navbar-brand">www.STCMediaBlog.com</a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
<span class="navbar-toggler-icon"></span>
</button>
<ul class="navbar-nav ml-auto">
<li class="nav-item">
<a href="login.php" class="nav-link text-success"> 
<i class="fas fa-user-times"></i> Log In
</a>
</li>
</ul>
</div>
</nav>
<div style="height: 10px;background-color: #f4f4f4;"></div>
<!-----------------------------------NAV BAR END----------------------------------->
<hr>
<!-----------------------------------HEADER BEGINS--------------------------------->
<header class="bg-dark text-white py-3">
<div class="container">
<div class="row">
<div class="col-md-12 ">
<h1>
<i class="fas fa-text-height" style="color: white;"> 
Welcome to STC Media CMS Blog
</i>
</h1>
</div>
</div>
</div>
</header>
<!-----------------------------------HEADER ENDS----------------------------------->
<hr>
<?php //echo success_message();?>
<div style="margin: auto;height: 100%; width:75%; box-shadow: 10px 10px 5px grey;padding:10px;">
<h2 class="bg-secondary" style="padding: 15px 5px 15px 50px;color: white;">Please register to our blog</h2>
<p style="padding: 30px;"> If you want to share your thought and experiences about your life please <a href="register.php">register</a> to STC Media Inc Blog. You will be able to upload photos from your experience to show the world. You will be able to leave comments on the pictures.</p>
</div>
<hr>
<!-----------------------------------FOOTER BEGIN----------------------------------->
<div style="height: 10px;background-color: #f4f4f4;"></div>
<footer class="bg-secondary text-white" id="load">
<div class="container">
<div class="row">
<div class="col">
<p class="lead text-center">&copy; www.STCMediaBlog.com All Rights Reserved &nbsp | 
<span id="demo_1" style="color: white;"><?php echo $date_time;?></span>
</p>
</div>
</div>
</div>
</footer>
<div style="height: 10px;background-color: #f4f4f4;"></div>
<!-----------------------------------FOOTER ENDS----------------------------------->
<!------------------------------------BODY ENDS------------------------------------>
</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>