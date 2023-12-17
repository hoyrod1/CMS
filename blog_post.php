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
	<title>Blog Post Page</title>
	<!-- Latest compiled and minified CSS -->	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">	
	<script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="javascript/js_script.js"></script>
</head>
<!------------------------------------------BODY BEGINS------------------------------------------------->
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
				<?php 
					$connect   = new conn_cms;
					//QUERY WHEN SEARCH PARAMETER IS SET
					if (isset($_GET["search_button"])) 
					{
						$search_field    = test_input($_GET["search"]);
						$sql_search      = "SELECT * FROM post WHERE title LIKE :Search OR category LIKE :Search OR author LIKE :Search OR post LIKE :Search";
						$stmt_post = $connect->conn()->prepare($sql_search);
						$stmt_post->bindValue(':Search', '%'.$search_field.'%');
						$stmt_post->execute();
					}elseif (isset($_GET['page'])) 
					{//QUERY SET WHEN PAGE PARAMETER IS SET FOR PAGINATION
						$page = $_GET['page'];

						if($page < 1 || $page = 0)
						{
							$page_num = 0;

						}else
						{
//-----------------------------------------PAGINATION ERROR WAS $page_num = -4 FIXED WITH MATH OPERATION----------------------------------------------------// 
							$page = $_GET['page'];
							$page_num = ($page * 4) - 4;
						}

							$sql        = "SELECT * FROM post ORDER BY id LIMIT $page_num, 4";
							$stmt_post  = $connect->conn()->query($sql);

					}// QUERY WHEN CATEGORY IS ACTIVE IN THE URL
					elseif (isset($_GET['category'])) {
						$category  = $_GET['category'];
						$sql       = "SELECT * FROM post WHERE category = '$category' ORDER BY id";
						$stmt_post  = $connect->conn()->query($sql);
						/*
						$sql       = "SELECT * FROM post WHERE category = ':categoryName' ORDER BY id";
						$cat_stmt  = $connect->conn()->prepare($sql);
						$cat_stmt->bindValue(':categoryName', $category);
						$stmt_post = $cat_stmt->execute();
						*/
					}
					else
					{// QUERY FOR DEFAULT SQL 
						$sql_post  = "SELECT * FROM post ORDER BY id";
						$stmt_post = $connect->conn()->query($sql_post);
					}	
							while ($data_row = $stmt_post->fetch()) 
							{
									//$counter        = 1;
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
				 						<h4 style="color: purple;"> Post: <?php echo htmlentities($post_id); ?></h4>
				 						<small class="text-muted"><span class="text-dark">Category of <a href="blog_post.php?category=<?php echo htmlentities($category); ?>" target="_blank"><?php echo htmlentities($category); ?></a>
				 						<br> 
				 						Written by <a href="profile.php?admin_name=<?php echo htmlentities($author); ?>" target="_blank"><?php echo htmlentities($author); ?></a> on <?php echo htmlentities($post_date_time); ?></span></small>
				 						<span style="float:right;" class="badge badge-dark text-white">Comments:  <?php approved_comment_count('comments', $post_id); ?></span>
				 						<hr>
				 						<p class="card-text"><?php if (strlen($post)>150) {$post = substr($post, 0, 150)."...";} echo htmlentities($post); ?></p>
				 						<a href="full_post.php?id=<?php echo $post_id; ?>" target="_blank" style="float:right;"><span class="btn btn-info">Read More>></span></a>
				 					</div>
				 				</div>
				<?php 		} ?>
				<!---------------------------PAGINATION LINKS BEGIN------------------------->
				<nav>
					<ul class="pagination pagination-md">
						<!--THE BEGINNING OF PREVIOUS PAGE LINK-->
						<?php if (isset($page) && !empty($page))
						{ 
							if ($page > 1) 
							{ ?>
					 		<li class="page-item mr-2 mt-2"><a href="blog_post.php?page=<?php echo $page - 1;?>" class="page-link">&laquo;</a></li>	
				   <?php } 
							} ?>
						<!--THE ENDING OF PREVIOUS PAGE LINK-->

						<?php  
							$connect_p        = new conn_cms;
							$sql_p            = "SELECT COUNT(*) FROM post";
							$stmt_pagination  = $connect_p->conn()->query($sql_p);
							$total_rows       = $stmt_pagination->fetch();
							$pagination_count = array_shift($total_rows);
							$pagination_count = $pagination_count/4;
							$final_page_count = ceil($pagination_count);

							for($i = 1; $i <= $final_page_count; $i++)
							{
								if (isset($page)) 
								{	
									$page = $_GET['page'];
							//THE BEGINNING OF PAGINATION LINK//		
									if ($i == $page) 
									{
						?>				<li class="page-item active mr-2 mt-2"><a href="blog_post.php?page=<?php echo $i;?>" class="page-link"><?php echo $i; ?></a></li>
					<?php            }else
									{ ?>
									 	<li class="page-item mr-2 mt-2"><a href="blog_post.php?page=<?php echo $i;?>" class="page-link"><?php echo $i; ?></a></li>
							<!--THE ENDING OF PAGINATION LINK-->
					<?php  			 }   
								}    
							} ?>	
						<!--THE BEGINNING OF NEXT PAGE LINK-->
					<?php if (isset($page) && !empty($page))
						{ 
							if ($page+1 <= $final_page_count) 
							{ ?>
					 		<li class="page-item mr-2 mt-2"><a href="blog_post.php?page=<?php echo $page + 1;?>" class="page-link">&raquo;</a></li>	
				   <?php } 
							} ?>
						<!--THE ENDING OF NEXT PAGE LINK-->
					</ul>
				</nav>


			</div>
			<!-- MAIN AREA ENDS-->

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
		</div>
	</div>
	<!-- CONTAINER ENDS-->
	<hr>

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
<!------------------------------------------------BODY END--------------------------------------------------------->
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>	
</html>