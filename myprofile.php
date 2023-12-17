<?php 
require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");
$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();

//BEGINNING OF FETCHING EXISTING ADMIN DATA
$admin_id          = $_SESSION["user_id"];
$myProfile_connect = new conn_cms;
$myProfile_sql     = "SELECT * FROM admin WHERE id = '$admin_id'";
$myProfile_stmt    = $myProfile_connect->conn()->query($myProfile_sql);
while ($myprofile_row = $myProfile_stmt->fetch()) 
{
	$myProfile_username    = $myprofile_row['username'];
	$myProfile_name        = $myprofile_row['admin_name'];
	$myProfile_photo       = $myprofile_row['admin_photo'];
	$myProfile_title       = $myprofile_row['admin_headline'];
	$myProfile_bio         = $myprofile_row['admin_bio'];
}
//ENDING OF FETCHING EXISTING ADMIN DATA
if (isset($_POST['submit'])) 
{
	$editName      = test_input($_POST['editName']);
	$editHeadLine  = test_input($_POST['editHeadLine']);
	$enterBio      = test_input($_POST['enterBio']);
	// CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
	$target_dir      = "images/";
	$image           = $_FILES['image']['name'];
	$target_file     = $target_dir.basename($image);
	$image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    if (empty($editName) &&empty($editHeadLine) && empty($enterBio) && empty($image))
	{
		$_SESSION['error_message'] = "Please Update Your Profile!";
		//redirect("www.myprofile.php");

	}elseif (strlen($editHeadLine) > 31) {
		$_SESSION['error_message'] = "Headline should be less than 30 characters! ";
		redirect("myprofile.php");
	}elseif (strlen($enterBio) > 9999) {
		$_SESSION['error_message'] = "Your Bio should be less than 10000 characters! ";
		redirect("myprofile.php");
	}else 
	{            //QUERY TO UPDATE ADMINS DATA IN THE DATABASE
		 if (empty($editHeadLine) && empty($enterBio) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editName) && empty($enterBio) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_headline = '$editHeadLine' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editName) && empty($editHeadLine) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_bio = '$enterBio' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editName) && empty($editHeadLine) && empty($enterBio))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		}elseif (empty($editHeadLine) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_bio = '$enterBio' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editName) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_headline = '$editHeadLine', admin_bio = '$enterBio' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($enterBio) && empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_headline = '$editHeadLine' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}//IF ELSE FOR $editHeadLine AND editName
		elseif (empty($editHeadLine) && empty($editName))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_bio = '$enterBio', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);
			 move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		}//IF ELSE FOR $enterBio AND $editName
		elseif (empty($enterBio) && empty($editName))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_headline = '$editHeadLine', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);
			 move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		}//IF ELSE FOR $enterBio AND $editHeadline
		elseif (empty($enterBio) && empty($editHeadLine))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);
			 move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		}elseif (empty($image))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_headline = '$editHeadLine', admin_bio = '$enterBio' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editName))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_headline = '$editHeadLine', admin_bio = '$enterBio', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($editHeadLine))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_bio = '$enterBio', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}elseif (empty($enterBio))
		{
			$admin_id = $_SESSION["user_id"];
			$connect  = new conn_cms();
			$edit_sql = "UPDATE admin SET admin_name = '$editName', admin_bio = '$enterBio', admin_photo = '$image' WHERE id = $admin_id";
			$execute  = $connect->conn()->query($edit_sql);

		}else 
		{
		  $admin_id = $_SESSION["user_id"];	
		  $connect  = new conn_cms();
		  $edit_sql = "UPDATE admin SET admin_name = '$editName', admin_headline = '$editHeadLinet', admin_bio = '$enterBio', admin_photo = '$image' WHERE id = $admin_id";
		  $execute  = $connect->conn()->query($edit_sql);
		  move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		}
		if ($execute) 
		{
			
			$_SESSION['success_message'] = 'Your Profile Has Been Updated!!!';
			redirect("myprofile.php");

		}else
		{
			
			$_SESSION['error_message'] = "Your Profile Was Not Updated!";
			redirect("www.myprofile.php");

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
	<title>My Profile Page</title>
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
			<h1><i class="fas fa-user mr-2 text-success"> <?php echo htmlentities($myProfile_username); ?>'s Profile </i></h1>
			<small style="font-weight: bold;text-decoration: underline;"><?php echo htmlentities($myProfile_title) ; ?></small>
			</div>
		</div>
	</div>
	</header>
	<!-- HEADER ENDS-->
	<hr>
	<!-- BODY AREA BEGINS-->
	<body>
	<!-- MAIN AREA BEGIN -->
	<section class="container py-2 mb-4">
		<div class="row">
			<!-- BEGINNING OF LEFT AREA-->
			<div class="col-md-3" style="min-height:500px;">
				<div class="card">
					<div class="card-header bg-dark text-white">
						<h3 style="text-align: center;text-decoration: underline;"><?php echo htmlentities($myProfile_name) ; ?></h3>
					</div>
					<div class="card-body">
						<img src="<?php echo 'images/'. htmlentities($myProfile_photo) ;?>" class="block img-fluid" height="225px" width="205px">
					</div>
					<div class=""><?php echo htmlentities($myProfile_bio) ; ?></div>
				</div>
			</div>
			<!-- ENDING OF LEFT AREA-->
			<!-- BEGINNING OF RIGHT AREA-->
			<div class="col-md-9" style="min-height:500px;">
				<?php 
					echo error_message();
					echo success_message();
				 ?>
				<!-- FORM STARTS HERE-->	 
				<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
					<div class="card bg-dark text-light">
						<div class="card-header bg-secondary text-light">
							<h4 style="color: #3F628A;">Edit Profile</h1>
						</div>
				           <!-- EDIT NAME AND INSERT NEW HEADLINE -->
						<div class="card-body">
							<div class="form-group">
								<input class="form-control" id="title" type="text" name="editName" placeholder="Enter Your Name...">
							</div>
							<div class="form-group">
								<input class="form-control" id="title" type="text" name="editHeadLine" placeholder="Enter HeadLine...">
								<small class="text-muted">Add a Professional Headline</small>
								<span class="text-danger">Don't enter more than 30 characters</span>
							</div>
				           <!-- ENTER BIO -->								
							<div class="form-group bg-dark">
								<textarea class="form-control" id="post" name="enterBio" rows="8" cols="80" placeholder="Enter Bio..."></textarea>
							</div>
				           <!-- SELECT IMAGE INPUT-->								
							<div class="form-group py-2">
								<label for="image"><span style="color: white;">Select Image:</span></label>
									<div class="custom-file">	
									<input class="custom-file-input" type="file" name="image" id="image" value="">
									<label class="custom-file-label" for="image"> Select Image... </label>
									</div>
									</div>	
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
				<!-- FORM ENDS HERE-->
			</div>
			<!-- ENDING OF RIGHT AREA-->
		</div>
	</section>
	<!-- MAIN AREA ENDS-->
	</body>
	<!-- BODY AREA ENDS-->
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