<?php 

require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");

//BEGINNING OF FETCHING EXISTING ADMIN DATA
$admin_name      = $_GET["admin_name"];
$profile_connect = new conn_cms;
$profile_sql     = "SELECT admin_name, admin_headline, admin_bio, admin_photo FROM admin WHERE admin_name = :admin_name";
$profile_stmt    = $profile_connect->conn()->prepare($profile_sql);
$profile_stmt->bindValue(':admin_name', $admin_name);
$profile_stmt->execute();
$profile_results = $profile_stmt->rowcount();

if ($profile_results == 1) 
{

	while ($profile_row = $profile_stmt->fetch()) 
	{
		$profile_name        = $profile_row['admin_name'];
		$profile_photo       = $profile_row['admin_photo'];
		$profile_title       = $profile_row['admin_headline'];
		$profile_bio         = $profile_row['admin_bio'];
	}
	
}else
{
	$_SESSION["error_message"] = "There was a bad input!";
	redirect('blog_post.php?page=1');
}
//ENDING OF FETCHING EXISTING ADMIN DATA
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="BooBoo">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Profile Page</title>
	<!-- Latest compiled and minified CSS -->	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">	
	<script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="javascript/js_script.js"></script>
</head>
<body>
	<!-- NAV-BAR -->
	<div style="height: 10px;background-color: #f4f4f4;"></div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
		<div class="container">
				
				<a href="#" class="navbar-brand"> www.RodneyStCloud.com</a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarcollapseCMS">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a href="blog_post.php" class="nav-link">Home</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">About Page</a>
					</li>
					<li class="nav-item">
						<a href="blog_post.php?page=1" class="nav-link">Blog</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Contact Page</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Feature Page</a>
					</li>
				</ul>
				<!-- BEGINNING OF SEARCH FIELD-->
				<ul>
					<form class="form-inline d-none d-sm-block" action="search_post.php" target="_blank" method="" enctype="">
						<div class="form-group">
						<input class="form-control mr-2" type="text" name="search" placeholder="Type search...">
						<button class="btn btn-primary" name="search_button">Search</button>
						</div>
					</form>
				</ul>
				<!-- ENDING OF SEARCH FIELD-->
			</div>
		</div>
	</nav>
	<div style="height: 10px;background-color: #f4f4f4;"></div>
	<!-- NAV BAR END-->
	<hr>
	<!-- HEADER BEGINS-->
	<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-6 ">
			<h1><i class="fas fa-user mr-2 text-success mr-2"> <?php echo htmlentities($profile_name); ?> </i></h1>
			<h3><?php echo htmlentities($profile_title); ?></h3>
			</div>
		</div>
	</div>
	</header>
	<!-- HEADER ENDS-->
	<hr>
	<?php 
		echo error_message();
		echo success_message();
	?>
	<!-- BODY AREA BEGINS-->
	<body>
	<!-- MAIN AREA BEGIN -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="col-md-3">
				<img src="<?php echo 'images/'.htmlentities($profile_photo); ?>" class="d-block img-fluid mb-3 rounded-circle" alt="" height="200px" width="190px">
			</div>
			<div class="col-md-9" style="min-height: 400px;">
				<div class="card">
					<div class="card-body">
						<p class="lead"><?php echo htmlentities($profile_bio); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- MAIN AREA ENDS-->
	</body>
	<!-- BODY AREA ENDS-->
	<hr>
	<!-- FOOTER BEGIN -->
	<div style="height: 100px;background-color: #f4f4f4;"></div>
	<footer class="bg-secondary text-white" id="load">
		<div class="container">
			<div class="row">
				<div class="col">
				<p class="lead text-center">&copy; www.RodneyStCloud.com All Rights Reserved &nbsp | &nbsp<span id="demo_1" style="color: white;"><?php echo $date_time;?></span></p>
				</div>
			</div>
		</div>
	</footer>
	<div style="height: 10px;background-color: #f4f4f4;"></div>
	<!-- FOOTER ENDS -->	
	<!--
	<script>
				var d_1 = new Date();
				var d = d_1.toDateString();
				document.getElementById("demo_2").innerHTML = d;
		/*
		document.getElementById("load").onload = function () {my_time_fuction(); my_date_fuction();};
		function my_time_fuction()
				{
				var d_1 = new Date();
				var n = d_1.getMinutes();
				document.getElementById("demo_1").innerHTML = n;
				}
		function my_date_fuction()
				{
				var d_1 = new Date();
				var d = d_1.toDateString();
				document.getElementById("demo_2").innerHTML = d;
				}
		*/
	</script>	
	-->
</body>
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>	
</html>