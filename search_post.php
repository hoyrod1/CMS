<?php
	require_once("includes/db_conn.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");
	require_once("includes/date_time.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="BooBoo">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Search Page</title>
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
						<a href="blog_post.php" class="nav-link">Blog</a>
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
					<form class="form-inline d-none d-sm-block" action="search_post.php" method="" enctype="">
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
	<!-- CONTAINER BEGINS-->
	<div class="container">
		<div class="row mt-4">
			<!-- MAIN AREA BEGINS-->
			<div class="col-sm-8" style="min-height: 40px;background-color:#666699;">
				<h1 style="color: white;font-family: Times, Arial, serif; font-size: 35px;"> Welcome to Rodney St. Cloud's Blog</h1>
				<h1 class="lead" style="color: white;font-family: Times, Arial, serif;">The most polpular adult blogging platform on the internet!!!</h1>
				<?php 
					$connect   = new conn_cms;

					if (isset($_GET["search_button"])) 
					{
						$search_field    = test_input($_GET["search"]);
						$sql_search      = "SELECT * FROM post WHERE title LIKE :Search OR category LIKE :Search OR author LIKE :Search OR post LIKE :Search";
						$stmt_post = $connect->conn()->prepare($sql_search);
						$stmt_post->bindValue(':Search', '%'.$search_field.'%');
						$stmt_post->execute();
					}
					else
					{
						$sql_post  = "SELECT * FROM post ORDER BY id DESC";
						$stmt_post = $connect->conn()->query($sql_post);
					}	
							while ($data_row = $stmt_post->fetch()) 
							{
									
									$post_id   = $data_row['id'];
									$post_date_time = $data_row['datetime'];
									$title     = $data_row['title'];
									$category  = $data_row['category'];
									$author    = $data_row['author'];
									$image     = $data_row['image'];
									$post      = $data_row['post'];
				 			
				 ?>
				 				<div class="card"><!-- <dive style="width:250px; margin:auto; padding:5px; border: solid 4px #666699;"> -->
				 					<img src="<?php echo 'uploads/'.htmlentities($image); ?>" max-height="300px" class="img-fluid card-img-top"><!--</div> -->
				 					
				 					<div class="card-body">
				 						<h4 class="card-title"><?php htmlentities($post_id); ?></h4>
				 						<small class="text-muted">Written by <?php echo htmlentities($author); ?> on <?php echo htmlentities($post_date_time); ?></small>
				 						<span style="float:right;" class="badge badge-dark text-white">Comments 20</span>
				 						<hr>
				 						<p class="card-text"><?php if (strlen($post)>150) {$post = substr($post, 0, 150)."...";} echo htmlentities($post); ?></p>
				 						<a href="full_post.php?id=<?php echo $post_id; ?>" style="float:right;"><span class="btn btn-info">Read More>></span></a>
				 					</div>
				 				</div>
				<?php 		} ?>
			</div>
			<!-- MAIN AREA ENDS-->
			<!-- SIDE AREA BEGINS-->
			<div class="col-sm-4" style="min-height: 40px;background-color:#9494b8;">
				
			</div>
			<!-- SIDE AREA ENDS-->
		</div>
	</div>
	<!-- CONTAINER ENDS-->
	<hr>

	<hr>
	<!-- BODY BEGINS-->
	<body>
		
	</body>
	<!-- BODY END -->
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