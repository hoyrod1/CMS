<?php 
require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");
//$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$search_param = $_GET['id'];
if (isset($search_param)) 
{
	$connect_post = new conn_cms();
	$select_post = "SELECT * FROM post WHERE id = '$search_param'";
	$show_post = $connect_post->conn()->query($select_post);

	while ($post_row = $show_post->fetch()) 
	{
		$old_title       = $post_row['title'];	
		$old_category    = $post_row['category'];	
		$old_image       = $post_row['image'];	
		$old_post        = $post_row['post'];	
	}
}

if (isset($_POST['submit'])) 
{
	/*
	$edit_title           = test_input($_POST['edit_title']);
	$edit_categoryTitle   = test_input($_POST['edit_categoryTitle']);
	$edit_post            = test_input($_POST['edit_post']);
	$admin           = "Rodney St. Cloud";
	// CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
	$target_dir      = "uploads/";
	$image           = $_FILES['edit_image']['name'];
	$target_file     = $target_dir.basename($image);
	$image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	*/
		$connect = new conn_cms();
		$delete_sql = "DELETE FROM post WHERE id = $search_param";
		$execute = $connect->conn()->query($delete_sql);

		if ($execute) 
		{
			$remove_image = "uploads/$old_image";
			unlink($remove_image);
			$_SESSION['success_message'] = 'Your Post Has Been Deleted!!!';
			redirect("post.php");
		}else
		{
			$_SESSION['success_message'] = "Post Was Not Deleted!";
			redirect("www.delete_post.php?id=<?php echo $edit_post_id; ?>");
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
	<title>Delete Post</title>
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
			<h1><i class="fas fa-edit" style="color: #3F628A;"> Delete Post </i></h1>
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
				 ?>
				<!-- FORM STARTS HERE-->	 
				<form class="" action="delete_post.php?id=<?php echo $search_param; ?>" method="post" enctype="multipart/form-data">
					<div class="card bg-secondary">
						<div class="card-header">
							<h1 style="color: #3F628A;">Delete Post</h1>
						</div>
				<!-- INSERT NEW TITLE -->
						<div class="card-body bg-dark">
							<div class="form-group">
								<label for="title"><span class="label"> Existing Title: </span></label>
								<input class="form-control" id="title" type="text" name="edit_title" placeholder="Please Enter Title..." value="<?php echo $old_title; ?>" disabled>
							</div>
				<!--------------------------------------------------DISABLING CATEGORY FIELD AND SELECT IMAGE FEILD ---------------------------------------------------->			
				<!-- SELECT NEW CATEGORY -->

								<div class="form-group"><span class="label">Existing Category: <?php echo $old_category; ?></span></div>
							<!--	<label for="categoryTitle"><span class="label"> Update Category: </span></label>
								<select class="form-control" id="categoryTitle" name="edit_categoryTitle">
									<option value="">Select...</option>
									<?php /*
									$connect = new conn_cms;
									$sql     = "SELECT * FROM category";
									$stmt    = $connect->conn()->query($sql);
									while ($data_row = $stmt->fetch()) {
										$id           = $data_row['id'];
										$category     = $data_row['title'];
									
									?>
									<option><?php echo $category;?></option>
									<?php } */?>
								</select> -->
				<!------SELECT IMAGE INPUT---->							
							<div class="form-group py-2">
								<div class="form-group"><span class="label">Existing Image: </span><img src="<?php echo 'uploads/'.$old_image; ?>" width="100"></div>
							<!--	<label for="image"><span style="color: white;">Update Image:</span></label>
									<div class="custom-file">	
									<input class="custom-file-input" type="file" name="edit_image" id="image" value="">
									<label class="custom-file-label" for="image"> Select Image... </label>
									</div>
									</div> -->	
							</div> 
				<!--------------------------------------------------DISABLING CATEGORY FIELD AND SELECT IMAGE FEILD ---------------------------------------------------->
				<!-- POST DESCRIPTION OF TITLE AND CATEGORY -->								
							<div class="form-group bg-dark px-4 py-2">
								<label for="post"><span style="color: white;">Update Post Description:</span></label>
								<textarea name="edit_post" class="form-control" id="post" rows="8" cols="80" disabled><?php echo $old_post; ?></textarea>
							</div>
				<!-- NAVIGATE BACK TO DASHBOARD AND SUBMIT BUTTON -->	
							<div class="row py-3">
								<div class="col-lg-6 mb-2">
									<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="submit" class="btn btn-danger btn-block" onclick="confirm('Are you sure you want to delete this record?');"><i class="fas fa-trash"></i> Delete Post</button>	
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