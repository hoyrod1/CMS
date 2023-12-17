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
	<title>Post Page</title>
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
			<h1><i class="fas fa-blog" style="color: #3F628A;"> Welcome to the Blog Post page</i></h1>
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
	<!-- MAIN BODY BEGINS-->
	<section class="container py-2 mb-2">
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-striped table-hover">
					<thead class="thead-dark">

					<tr >
						<th>ID #</th>
						<th>Title</th>
						<th>Category</th>
						<th>Date & Time</th>
						<th>Author</th>
						<th>Banner Photo</th>
						<th>Comments</th>
						<th>Action</th>
						<th>Live Preview</th>
					</tr>
					</thead>
					<?php 

					//CONNECT TO THE DATABASE FOR QUERY
					$connect = new conn_cms;

					$sql      = "SELECT * FROM  post";
					$sql_stmt = $connect->conn()->query($sql);
					$counter    = 0;
					//FETCH ALL THE DATA FROM THE POST TABLE AND STORE IN VARIABLE
					while ($data_rom = $sql_stmt->fetch()) {
						
						$id         = $data_rom['id'];
						$title      = $data_rom['title'];
						$category   = $data_rom['category'];
						$date_Time  = $data_rom['datetime'];
						$author     = $data_rom['author'];
						$image      = $data_rom['image'];
						$post       = $data_rom['post'];
						$counter++;

					 ?>
					 <!--DISPLAY ALL THE DATA FTECHED FROM THE POST TABLE-->
					<tbody>
					 <tr>
					 	<td><?php echo $counter; ?></td>
					 	<td><?php if (strlen($title)>9) { $title = substr($title, 0,8).'..'; }  echo $title; ?></td>
					 	<td><?php if (strlen($category)>9) { $category = substr($category, 0,8).'..'; } echo $category; ?></td>
					 	<td><?php if (strlen($date_Time)>9) { $date_Time = substr($date_Time, 0,8).'..'; }  echo $date_Time; ?></td>
					 	<td><?php echo $author ?></td>
					 	<td><img src="<?php echo 'uploads/'.$image; ?>" width="50"></td>
					 	<td style="font-size: 25px;padding: 5px;">
								<span class="badge badge-success"><?php approved_comment_count('comments', $id); ?></span>
								<span class="badge badge-danger"><?php disapproved_comment_count('comments', $id); ?></span>
							</td>
					 	<td>
					 		<a href="update_post.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-warning">Edit</span></a>
					 		<a href="delete_post.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-danger">Delete</span></a>
					 	</td>
					 	<td><a href="full_post.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
					 </tr>
					 </tbody>
					<?php } ?>
				</table>
			</div>
		</div>
	</section>
	
	</body>
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