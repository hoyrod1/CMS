<?php
	require_once("includes/db_conn.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");
	require_once("includes/date_time.php");
    $_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login(); 
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="BooBoo">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Dashboard Page</title>
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
						<a href="myprofile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
					</li>
					<li class="nav-item">
						<a href="dashboard.php" class="nav-link">Dashboard</a>
					</li>
					<li class="nav-item">
						<a href="post.php" class="nav-link">Post</a>
					</li>
					<li class="nav-item">
						<a href="categories.php" class="nav-link">Categories</a>
					</li>
					<li class="nav-item">
						<a href="admin.php" class="nav-link">Manage Admins</a>
					</li>
					<li class="nav-item">
						<a href="comments.php" class="nav-link">Comments</a>
					</li>
					<li class="nav-item">
						<a href="blog_post.php?page=1" class="nav-link">Live Blog</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a href="logout.php" class="nav-link text-danger"> <i class="fas fa-user-times"></i> Log Out</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div style="height: 10px;background-color: #f4f4f4;"></div>
	<!-- NAV BAR END-->
	<hr>
	<body>
	<!-- HEADER BEGINS-->
	<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mb-2">
			<h1><i class="fas fa-cog" style="color: #3F628A;"> Welcome to the Dashboard page</i></h1>
			</div>
			<div class="col-lg-3 mb-2">
				<a href="create_add_post.php" target="_blank" class="btn btn-primary btn-block"> <i class="fas fa-edit">Add New Post</i></a>
			</div>
			<div class="col-lg-3 mb-2">
				<a href="categories.php" target="_blank" class="btn btn-info btn-block"> <i class="fas fa-folder-plus">Add New Category</i></a>
			</div>
			<div class="col-lg-3 mb-2">
				<a href="admin.php" target="_blank" class="btn btn-warning btn-block"> <i class="fas fa-user-plus">Add New Admin</i></a>
			</div>
			<div class="col-lg-3 mb-2">
				<a href="comments.php" target="_blank" class="btn btn-success btn-block"> <i class="fas fa-check">Approve Comment</i></a>
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
	<hr>
	<!-- MAIN BODY SECTION BEGINS-->
	<section class="container py-2 mb-4">
		<div class="row">
			<!----------------------------------------------------------LEFT SIDE BEGINS ---------------------------------------------------------->
			<div class="col-lg-2 d-none d-md-block">
			<!----TOP LEFT SIDE START --->
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Post</h1>
				 		<h4 class="display-5">
				 			<i class="fab fa-readme"></i>
				 			<?php 
				 				dashboard_count ('post');
				 			?>
				 		</h4>
				 	</div>
				 </div>
			<!----TOP MIDDLE LEFT SIDE START --->
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Categories</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-folder"></i>
				 			<?php 
				 				dashboard_count ('category');
				 			?>
				 		</h4>
				 	</div>
				 </div>
			<!----TOP MIDDLE LEFT SIDE ENDS --->
			<!----BOTTOM MIDDLE LEFT SIDE START --->
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Admins</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-users"></i>
				 			<?php 
				 				dashboard_count ('admin');
				 			?>
				 		</h4>
				 	</div>
				 </div>
			<!----BOTTOM MIDDLE LEFT SIDE ENDS --->
			<!----BOTTOM LEFT SIDE START --->
				 <div class="card text-center bg-dark text-white mb-3">
				 	<div class="card-body">
				 		<h1 class="lead">Cooments</h1>
				 		<h4 class="display-5">
				 			<i class="fas fa-comments"></i>
				 			<?php  
				 				dashboard_count ('comments');
				 			?>
				 		</h4>
				 	</div>
				 </div>
			<!----BOTTOM LEFT SIDE ENDS --->
			</div>
			<!----------------------------------------------------------LEFT SIDE ENDS----------------------------------------------------------->
			
			<!--------------------------------------------------------RIGHT SIDE BEGIINS--------------------------------------------------------->
			<div class="col-lg-10">
				<h1>Top Post</h1>
				<table class="table table-strip table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Title</th>
							<th>Date & Time</th>
							<th>Author</th>
							<th>Comments</th>
							<th>Details</th>
						</tr>
					</thead>
				<?php 
					$conn  = new conn_cms;
					$sql   = "SELECT * FROM post ORDER BY id LIMIT 0,5";
					$stmt  = $conn->conn()->query($sql);
					$count = 0; 
					while ($post_rows = $stmt->fetch()) 
					{
						$count++;	
						$post_id            = $post_rows['id'];
						$post_title         = $post_rows['title'];
						$post_date_time     = $post_rows['datetime'];
						$post_author        = $post_rows['author'];
						//$post_comments      = $post_rows['id'];
						//$post_details       = $post_rows['id'];
						if (strlen($post_title) > 9){ $post_title = substr($post_title, 0, 8);};
					
				?>
					<tbody>
						<tr>
							<td><?php echo $count; ?></td>
							<td><?php echo $post_title; ?></td>
							<td><?php echo $post_date_time; ?></td>
							<td><?php echo $post_author; ?></td>
							<td style="font-size: 25px;padding: 5px;">
								<span class="badge badge-success"><?php approved_comment_count('comments', $post_id); ?></span>
								<span class="badge badge-danger"><?php disapproved_comment_count('comments', $post_id); ?></span>
							</td>							
							<td><a href="full_post.php?id=<?php echo $post_id; ?>" target="_blank"><span class="btn btn-info">Preview</span></a></td>
						</tr>
					</tbody>
				<?php } ?>
				</table>
			</div>
			<!----------------------------------------------------------RIGHT SIDE ENDS---------------------------------------------------------->
		</div>
	</section>
	<!-- MAIN BODY SECTION ENDS-->
	<!-- FOOTER BEGIN -->
	<div style="height: 10px;background-color: #f4f4f4;"></div>
	<footer class="bg-secondary text-white" id="load">
		<div class="container">
			<div class="row">
				<div class="col">
				<p class="lead text-center">&copy; www.RodneyStCloud.com All Rights Reserved &nbsp | <span id="demo_1" style="color: white;"><?php echo $date_time;?></span> </p>
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