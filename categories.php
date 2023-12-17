<?php 
require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");
$_SESSION['trackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
if (isset($_POST['submit'])) 
{
	$categoryTitle = test_input($_POST['newtitle']);
	$admin         = $_SESSION['user_name'];

	if (empty($categoryTitle)) 
	{
		$_SESSION['error_message'] = "Please fill out the form";
		redirect("categories.php");
	}elseif (strlen($categoryTitle) < 3) {
		$_SESSION['error_message'] = "Category Title should be more than 2 characters! ";
		redirect("categories.php");
	}elseif (strlen($categoryTitle) > 100) {
		$_SESSION['error_message'] = "Category Title should be less than 100 characters! ";
		redirect("categories.php");
	}else 
	{
		$connect = new conn_cms;

		// $sql      = "INSERT INTO category(title, author, date_time) VALUES(:searchTitle, :searchAuthor, :searchDate_Time)";
		// $pre_stmt = $connect->conn()->prepare($sql);
		// $pre_stmt->bindValue(':searchTitle', $categoryTitle);
		// $pre_stmt->bindValue(':searchAuthor', $admin);
		// $pre_stmt->bindValue(':searchDate_Time', $date_time);
		$sql      = "INSERT INTO category(title, author) VALUES(:searchTitle, :searchAuthor)";
		$pre_stmt = $connect->conn()->prepare($sql);
		$pre_stmt->bindValue(':searchTitle', $categoryTitle);
		$pre_stmt->bindValue(':searchAuthor', $admin);
		$execute = $pre_stmt->execute();
		if ($execute) 
		{
			
			$_SESSION['success_message'] = 'Category Title ID: ' .$connect->conn()->lastInsertId(). ' was Sent.';
			redirect("categories.php");

		}else
		{
			
			$_SESSION['success_message'] = "Record has not been submitted!";
			redirect("categories.php");

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
	<title>Categories</title>
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
			<h1><i class="fas fa-edit" style="color: #3F628A;"> Manage catergories </i></h1>
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
				 <!----------------BEGINNING OF FORN----------------------->
				<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
					<div class="card bg-secondary">
						<div class="card-header">
							<h1 style="color: #3F628A;">Add New Category</h1>
						</div>
						<div class="card-body bg-dark">
							<div class="form-group">
								<label for="title"><span class="label"> Category Title: </span></label>
								<input class="form-control" id="title" type="text" name="newtitle" placeholder="Type title here...">
							</div>
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
				<!-----------------END OF FORM------------------------------>

				 <h2>Existing Categories</h2>
				<!----------BEGINNING OF TABLE HEADING------->
				<table class="table table-striped table-hover">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Category Name</th>
							<th>Date & Time</th>
							<th>Creator Name</th>
							<th>Action</th>
						</tr>
					</thead>	
				<!---------ENDING OF TABLE HEADING------------>

				<!----------BEGINNING OF CATEGORIY TABLE DATA------->
				<?php  
				$conn     = new conn_cms;
				$sql      = "SELECT * FROM category ORDER BY id DESC";
				$execute  = $conn->conn()->query($sql);
				//$sql_results =
				$count    = 1; 
				while ($comment_rows = $execute->fetch()) 
				{
					
					$category_count           = $count++;
					$catgory_id               = $comment_rows['id'];
					$category_date_time       = $comment_rows['date_time'];
					$category_title           = $comment_rows['title'];
					$comment_name             = $comment_rows['author'];
				
				?>
					<thead>
						<tr>
							<td><?php echo htmlentities($category_count); ?></td>
							<td><?php echo htmlentities($category_title); ?></td>
							<td><?php echo htmlentities($category_date_time); ?></td>
							<td><?php echo htmlentities($comment_name); ?></td>
							<td><a href="delete_category.php?id=<?php echo $catgory_id; ?>" class="btn btn-danger">Delete</a></td>
							</td>
						</tr>
					</thead>
				<?php  } ?>	
				</table>
				<!----------ENDING OF CATEGORIY TABLE DATA------->
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