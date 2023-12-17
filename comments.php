<?php
	require_once("includes/db_conn.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");
	require_once("includes/date_time.php");
	$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login();
?>
<?php 
					
					$connect_c   = new conn_cms;
					$sql_comment  = "SELECT * FROM comments WHERE post_id = 'full_post_id'";
					$stmt_comment = $connect_c->conn()->query($sql_comment);

					while ($comment_row = $stmt_comment->fetch()) 
					{
						$c_date    = $comment_row['date_time'];
						$c_name    = $comment_row['name'];
						$c_comment = $comment_row['comment'];	
					
				?>
					<div>
						<span class="FieldInfo"><?php echo $test; ?></span>
						<div class="">
							<div class="">
								<h6 class=""><?php echo $c_name; ?></h6>
								<p class=""><?php echo $c_date; ?></p>
								<p><?php echo $c_comment; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="BooBoo">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Comments</title>
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
	<!-- HEADER BEGINS-->
	<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12 ">
			<h1><i class="fas fa-comments" style="color: #3F628A;"> Welcome to the Manage Comment page</i></h1>
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
	<section class="container py-2 mb-4">
		<div class="row" style="min-height: 30px;">
			<div class="col-lg-12" style="min-height: 400px;">
				<h2>Un-Approve Comments</h2>
				<!----------BEGINNING OF TABLE HEADING------->
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date & Time</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
					</thead>	
				<!---------ENDING OF TABLE HEADING------------>

				<!----------BEGINNING OF TABLE DATA------->
				<?php  
				$conn     = new conn_cms;
				$sql      = "SELECT * FROM comments WHERE comment_status = 'off' ORDER BY id DESC";
				$execute  = $conn->conn()->query($sql);
				//$sql_results =
				$count    = 1; 
				while ($comment_rows = $execute->fetch()) 
				{
					
					$comment_count           = $count++;
					$comment_id              = $comment_rows['id'];
					$comment_date_time       = $comment_rows['date_time'];
					$comment_name            = $comment_rows['name'];
					$comment_email           = $comment_rows['email'];
					$comment_comments        = $comment_rows['comment'];
					$comment_post_id         = $comment_rows['post_id'];
					if (strlen($comment_date_time) > 9) { $comment_date_time = substr($comment_date_time, 0,8); }
					if (strlen($comment_name) > 6) { $comment_name = substr($comment_name, 0,5).".."; }
					//if (strlen($comment_comments) > 30) { $comment_comments = substr($comment_comments, 0, 29)."...."; }
				?>
					<thead>
						<tr>
							<td><?php echo htmlentities($comment_count); ?></td>
							<td><?php echo htmlentities($comment_name); ?></td>
							<td><?php echo htmlentities($comment_date_time); ?></td>
							<td><?php echo htmlentities($comment_comments); ?></td>
							<td style="min-width: 150px;"><a href="approve_comment.php?id=<?php echo $comment_id;?>" class="btn btn-success">Approve</a></td> 
							<td><a href="delete_comment.php?id=<?php echo $comment_id; ?>" class="btn btn-danger">Delete</a></td>
							<td style="min-width: 160px;"> <a class="btn btn-primary" href="full_post.php?id=<?php echo $comment_id; ?>" target="_blank">Full Comment</a></td>
						</tr>
					</thead>
				<?php  } ?>	
				</table>
		        <!----------ENDING OF FETCHING TABLE DATA------->
		        <h2>Approve Comments</h2>
				<!----------BEGINNING OF TABLE HEADING------->
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date & Time</th>
							<th>Comment</th>
							<th>Revert</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
					</thead>	
				<!---------ENDING OF TABLE HEADING------------>

				<!----------BEGINNING OF TABLE DATA------->
				<?php  
				$conn     = new conn_cms;
				$sql      = "SELECT * FROM comments WHERE comment_status = 'ON' ORDER BY id DESC";
				$execute  = $conn->conn()->query($sql);
				//$sql_results =
				$count    = 1; 
				while ($comment_rows = $execute->fetch()) 
				{
					
					$comment_count           = $count++;
					$comment_id              = $comment_rows['id'];
					$comment_date_time       = $comment_rows['date_time'];
					$comment_name            = $comment_rows['name'];
					$comment_email           = $comment_rows['email'];
					$comment_comments        = $comment_rows['comment'];
					$comment_post_id         = $comment_rows['post_id'];
					if (strlen($comment_date_time) > 9) { $comment_date_time = substr($comment_date_time, 0,8); }
					if (strlen($comment_name) > 6) { $comment_name = substr($comment_name, 0,5).".."; }
					//if (strlen($comment_comments) > 30) { $comment_comments = substr($comment_comments, 0, 29)."...."; }
				?>
					<thead>
						<tr>
							<td><?php echo htmlentities($comment_count); ?></td>
							<td><?php echo htmlentities($comment_name); ?></td>
							<td><?php echo htmlentities($comment_date_time); ?></td>
							<td><?php echo htmlentities($comment_comments); ?></td>
							<td style="min-width: 150px;"><a href="dis_approve_comment.php?id=<?php echo $comment_id;?>" class="btn btn-warning">Dis-Approve</a></td> 
							<td><a href="delete_comment.php?id=<?php echo $comment_id; ?>" class="btn btn-danger">Delete</a></td>
							<td style="min-width: 160px;"> <a class="btn btn-primary" href="full_post.php?id=<?php echo $comment_id; ?>" target="_blank">Full Comment</a></td>
						</tr>
					</thead>
				<?php  } ?>	
				</table>
			</div>
		</div>
	</section>
	<hr>
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