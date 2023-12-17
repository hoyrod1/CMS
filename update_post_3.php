<?php 
require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");

$search_param = $_GET['id'];
if (isset($_POST['submit'])) 
{
	$update_Post            = test_input($_POST['updateTitle']);
	$update_categoryTitle   = test_input($_POST['categoryTitle']);
	$update_postdesciption  = test_input($_POST['postdesciption']);
	$admin                  = "Rodney St. Cloud";
	// CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
	$target_dir             = "uploads/";
	$image                  = $_FILES['image']['name'];
	$target_file            = $target_dir.basename($image);
	$image_file_type        = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if (empty($updateTitle)) 
	{
		$_SESSION['error_message'] = "Please fill out the form";
		redirect("post.php");
	}elseif (strlen($updateTitle) < 3) {
		$_SESSION['error_message'] = "Category Title should be more than 2 characters! ";
		redirect("update_post.php");
	}elseif (strlen($updateTitle) > 100) {
		$_SESSION['error_message'] = "Title should be less than 100 characters! ";
		redirect("create_add_post.php");
	}elseif (strlen($postdesciption) > 9999) {
		$_SESSION['error_message'] = "Your Post should be less than 10000 characters! ";
		redirect("categories.php");
	}else 
	{
		$connect = new conn_cms();

		$sql     = "UPDATE post SET title = '$update_post', category = '$update_categoryTitle', image = 'image', post = 'update_postdesciption' 
		           WHERE id = '$search_param'";
		$execute = $connect->conn()->query($sql);
		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		if ($execute) 
		{
			
			$_SESSION['success_message'] = 'Posted Title With ID: ' .$connect->conn()->lastInsertId(). ' Was Added.';
			redirect("post.php");

		}else
		{
			
			$_SESSION['success_message'] = "Post Was Not Added!";
			redirect("post.php");

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
	<title>Update Post</title>
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
						<a href="blog.php?page=1" class="nav-link">Live Blog</a>
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
			<h1><i class="fas fa-edit" style="color: #3F628A;"> Update Post </i></h1>
			</div>
		</div>
	</div>
	</header>
	<!-- HEADER ENDS-->
	<hr>
	<body>
	<!-- MAIN AREA BEGIN -->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="offset-lg-1 col-md-10 bg-light" style="min-height:500px;">
				<?php 
					echo error_message();
					echo success_message();

					$update_conn = new conn_cms();
					$update_sql  = "SELECT * FROM post WHERE id = '$search_param'";
					$show_query  = $update_conn->conn()->query($update_sql);

					while ($show_post = $show_query->fetch()) 
					{
						$current_title     = $show_post['title'];
						$current_category  = $show_post['category'];
						$current_image     = $show_post['image'];
						$current_post      = $show_post['post']; 
					}
				 ?>
				<!-- FORM STARTS HERE-->	 
				<form class="" action="update_post.php?<?php echo $search_param; ?>" method="post" enctype="multipart/form-data">
					<div class="card bg-secondary">
						<div class="card-header">
							<h1 style="color: #3F628A;">Update Post</h1>
						</div>
				<!-- INSERT NEW TITLE -->
						<div class="card-body bg-dark">
							<div class="form-group">
								<label for="title"><span class="label"> Update Title: </span></label>
								<input class="form-control" id="title" type="text" name="updateTitle" placeholder="Type title here..." value="<?php echo $current_title; ?>">
							</div>
				<!-- SELECT NEW CATEGORY -->
								<div class="form-group"><span class="label">The current Category: <?php echo $current_category; ?></span></div>
								<label for="categoryTitle"><span class="label"> Update Category: </span></label>
								<select class="form-control" id="categoryTitle" name="categoryTitle">
									<option value="">Select...</option>
									<?php 
									$connect = new conn_cms;
									$sql     = "SELECT * FROM category";
									$stmt    = $connect->conn()->query($sql);
									while ($data_row = $stmt->fetch()) {
										$id           = $data_row['id'];
										$category     = $data_row['title'];
									
									?>
									<option><?php echo $category;?></option>
									<?php } ?>
								</select>
				<!-- SELECT IMAGE INPUT-->								
							<div class="form-group py-2">
								<div class="form-group"><span class="label">Current Image: </span><img src="<?php echo 'uploads/'.$current_image; ?>" width="100"></div>
								<label for="image"><span style="color: white;">Update Image:</span></label>
									<div class="custom-file">	
									<input class="custom-file-input" type="file" name="image" id="image" value="">
									<label class="custom-file-label" for="image"> Select Image... </label>
									</div>
									</div>	
							</div>
				<!-- POST DESCRIPTION OF TITLE AND CATEGORY -->								
							<div class="form-group bg-dark px-4 py-2">
								<label for="post"><span style="color: white;">Update Post Description:</span></label>
								<textarea name="postdesciption" class="form-control" id="post" rows="8" cols="80"><?php echo $current_post; ?></textarea>
							</div>
				<!-- NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON -->	
							<div class="row py-3">
								<div class="col-lg-6 mb-2">
									<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Submit</button>	
								</div>
							</div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</section>

	</body>
	<!-- MAIN AREA ENDS-->
	<hr>
	<!-- FOOTER BEGIN -->
	<div style="height: 10px;background-color: #f4f4f4;"></div>
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