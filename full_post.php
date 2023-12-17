<?php
	require_once("includes/db_conn.php");
	require_once("includes/functions.php");
	require_once("includes/session.php");
	require_once("includes/date_time.php");

	$full_post_id = $_GET['id'];
	if (isset($_POST['submit'])) 
				{
					//$date_time = test_input($_POST['newtitle']);
					$name      = test_input($_POST['commenter_name']);
					$email     = test_input($_POST['commenter_email']);
					$comment   = test_input($_POST['commenter_thoughts']);

				if (empty($name) || empty($email) || empty($comment)) 
					{
						$_SESSION['error_message'] = "Please fill out the form";
						redirect("full_post.php?id=$full_post_id");
					}elseif (strlen($comment) > 500) {
						$_SESSION['error_message'] = "Category Title should be less than 500 characters! ";
						redirect("full_post.php?id=$full_post_id");
					}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$_SESSION['error_message'] = "Please enter vailid email! ";
						redirect("full_post.php?id=$full_post_id");
					}
					else 
					{
						$connect = new conn_cms;

						$sql      = "INSERT INTO comments(date_time, name, email, comment, approved_by, comment_status, post_id) VALUES(:comment_Date_Time, :Name, :Email, :Comment, 'CommentPending', 'off', :post_id)";
						$pre_stmt = $connect->conn()->prepare($sql);
						$pre_stmt->bindValue(':comment_Date_Time', $date_time);
						$pre_stmt->bindValue(':Name', $name);
						$pre_stmt->bindValue(':Email', $email);
						$pre_stmt->bindValue(':Comment', $comment);
						$pre_stmt->bindValue(':post_id', $full_post_id);
						$execute = $pre_stmt->execute();
						
						if ($execute) 
						{
			
							$_SESSION['success_message'] = 'Your comment successfully submited!';
							redirect("full_post.php?id=$full_post_id");

						}else
						{
			
							$_SESSION['success_message'] = "Your comment was not submited!";
							redirect("full_post.php?id=$full_post_id");

						}		
				}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="BooBoo">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Full Post</title>
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
	<!-- BODY BEGINS-->
	<body>
	<!-- CONTAINER BEGINS-->
	<div class="container">
				<?php 
					echo error_message();
					echo success_message();
				 ?>
		<div class="row mt-4">
			<!-- MAIN AREA BEGINS-->
			<div class="col-sm-8" style="min-height: 40px;background-color:#666699;">
				<h1 style="color: white;font-family: Times, Arial, serif; font-size: 35px;"> Welcome to Rodney St. Cloud's Blog</h1>
				<h1 class="lead" style="color: white;font-family: Times, Arial, serif;">The most polpular adult blogging platform on the internet!!!</h1>
			<!-------------------------- BEGGINING OF FULL POST QUERY --------------------->
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
						$post_full_id = $_GET["id"];
						/* IF STATEMENT FOR FULL POST WITH INVALID URL ID VALUE */
						if (!isset($post_full_id)) 
						{
							$_SESSION['error_message'] = "Invalid URL!";
							redirect('blog_post.php?page=1');
						}
						$sql_post         = "SELECT * FROM post WHERE id = '$post_full_id'";
						$stmt_post        = $connect->conn()->query($sql_post);
						$rowcount_results = $stmt_post->rowcount();
						if ($rowcount_results != 1) 
						{
							$_SESSION['error_message'] = "Post Not Found!";
							redirect('blog_post.php?page=1');

						}

					}	
							while ($data_row = $stmt_post->fetch()) 
							{
									
									$post_id        = $data_row['id'];
									$post_date_time = $data_row['datetime'];
									$title          = $data_row['title'];
									$category       = $data_row['category'];
									$author         = $data_row['author'];
									$image          = $data_row['image'];
									$post           = $data_row['post'];
				 			
				 ?>
				 				<div class="card"><!-- <dive style="width:250px; margin:auto; padding:5px; border: solid 4px #666699;"> -->
				 					<img src="<?php echo 'uploads/'.htmlentities($image); ?>" max-height="300px" class="img-fluid card-img-top"><!--</div> -->
				 					
				 					<div class="card-body">
				 						<h4 class="card-title">Post: <?php echo htmlentities($post_id); ?></h4>
				 						<small class="text-muted"><span class="text-dark">Category of <a href="blog_post.php?category=<?php echo htmlentities($category); ?>" target="_blank"><?php echo htmlentities($category); ?></a>
				 						<br> 
				 						Written by <a href="profile.php?admin_name=<?php echo htmlentities($author); ?>" target="_blank"><?php echo htmlentities($author); ?></a> on <?php echo htmlentities($post_date_time); ?></span></small>
				 						<span style="float:right;font-size: 15px;" class="badge badge-dark text-white">Comments: <?php approved_comment_count('comments', $post_id); ?></span>
				 						<hr>
				 						<p class="card-text"><?php echo nl2br($post); ?></p>
				 					</div>
				 				</div>
				 				<br>
				<?php 		} ?>
				<!---------------------------- ENDINING OF FULL POST QUERY -------------------------->
				<!----FETCH COMMENT AREA START-->
				<br>
				<span style="font-weight: bold;padding: 5px;color: white;font-size: 20px;">Comment: </span>
				<br>
				<?php 
					$connect = new conn_cms;
					$sql     = "SELECT * FROM comments WHERE post_id = '$full_post_id' AND comment_status = 'ON'";
					$stmt    = $connect->conn()->query($sql);
					while ($rows = $stmt->fetch()) 
					{
						$comment_date   = $rows['date_time'];
						$comment_name   = $rows['name'];
						$comment_post   = $rows['comment'];
					
				?>
				<div style="background-color: white; border: 2px blue solid;font-size: 17px;padding: 5px;border-radius: 5px">
					<div class="media">
						<img class="d-sm-block img-fluid align-self-start" src="uploads/Rodney_St._Cloud_NOC_pic4.JPEG" width="65">
						<div class="media-body ml-2">
							<h6 class="lead"><?php echo $comment_name; ?></h6>
							<p class="small"><?php echo $comment_date; ?></p>
						  	<p><?php echo $comment_post; ?></p>
						</div>
					</div>
				</div>
				<br>
				<?php } ?>
				<!----FETCH COMMENT AREA END-->	
				<!----COMMENT AREA START-->
				<div class="">
					<form class="" action="full_post.php?id=<?php echo $full_post_id; ?>" method="post">
						<div class="card mb-3">
							<div class="card-header">
								<h5 class="FieldInfo">Please Post Your Comments About This Post</h5>
							</div>
							<div class="card-body">

								<div class="form-group">
									<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" name="commenter_name" value="" placeholder="Name" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-envelope"></i></span>
									</div>
									<input type="email" name="commenter_email" value="" placeholder="Email" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<textarea name="commenter_thoughts" class="form-control" rows="6" cols="80"></textarea>
								</div>
								<div class="">
									<button type="submit" name="submit" class="btn btn-primary"> Submit </button>
								</div>

							</div>
						</div>
					</form>
				</div>
				<!----COMMENT AREA ENDS--->			
			</div>
			<!-- MAIN AREA ENDS-->
			
			<!-- SIDE AREA BEGINS-->
			<!-- SIDE AREA BEGINS-->
			<div class="col-sm-4">
				<div class="card mt-4">
					<div class="card-body" style="background-color:#666699;">
						<img src="images/sidearea pic.jpg" class="d-block img-fluid mb-3">
						<div class="text-center text-white">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
						</div>
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header bg-dark text-light">
						<h2 class="lead">Sign Up</h2>
					</div>
					<div class="card-body" style="background-color:#666699;">
						<button type="button" class="btn btn-success btn-block text-center text-white" name="button"> Join The Forum</button>
						<button type="button" class="btn btn-danger btn-block text-center" name="button"><a href="login.php" class="text-white">Login</a></button>
						<div class="input-group mt-3 mb-3">
							<input type="text" class="form-control" placeholder="Enter Your Email" name="">
							<div class="input-group-append">
								<button type="button" class="btn btn-primary btn-small text-center text-white">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="card">
					<div class="card-header bg-info text-white">
						<h2 class="text-center">Category's</h2>
					</div>
						<div class="card-body text-center" style="background-color:#666699;">
							<?php 
								$connect_c  = new conn_cms;
								$sql_cat      = "SELECT * FROM category ORDER BY id";
								$sql_stmt = $connect_c->conn()->query($sql_cat);

								while ($cat_row = $sql_stmt->fetch()) 
								{
									$cat_id   = $cat_row['id'];
									$cat_name = $cat_row['title'];
							 ?>
							 	<a href="blog_post.php?category=<?php echo $cat_name; ?>"><span class="heading text-white"><? echo $cat_name; ?></span></a>
							 	<br>
							<?php } ?>
						</div>
					</div>
					<br>
					<div class="card">
						<div class="card-header bg-info text-white">
							<h2 class="lead">Recent Post</h2>
						</div>
						<div class="card-body" style="background-color:#666699;">
							<?php  
							$rec_connect  = new conn_cms;
							$rec_sql      = "SELECT * FROM post ORDER BY id";
							$rec_stmt     = $connect->conn()->query($rec_sql);
							while ($rec_post = $rec_stmt->fetch()) 
							{
								$recent_id       = $rec_post['id'];
								$recent_title    = $rec_post['title'];
								$recent_datetime = $rec_post['datetime'];
								$recent_image    = $rec_post['image'];
							
							?>
							<div class="media mb-3" style="border: 2px solid white">
								<img src="<?php echo 'uploads/'.htmlentities($recent_image); ?>" width="70px" heigth="74" class="d-block img-fluid align-self-start">
								<div class="media-body ml-2">
									<a href="full_post.php?id=<?php echo htmlentities($recent_id); ?>" target="_blank"><h6 class="lead text-white"> Post: <?php echo htmlentities($recent_id); ?></h6></a>
									<p class="small"><?php echo htmlentities($recent_datetime); ?></p>
								</div>
							</div>
							<hr>
							<?php } ?>
						</div>
					</div>

				</div>
			<!-- SIDE AREA ENDS-->
			<!-- SIDE AREA ENDS-->
		</div>
	</div>
	<!-- CONTAINER ENDS-->
	<hr>		
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