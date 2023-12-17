<?php
/**
 * * @file
 * php version 8.2
 * Page for CMS registration
 * 
 * @category CMS
 * @package  Registration_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/www.registration.php
 */

// require_once "insert_into_database.php";
// require 'input_validation.php';
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/session.php";
require_once "includes/date_time.php";

if (isset($_POST['submit'])) {

    if (!empty($_POST['name'])
        && !empty($_POST['email']) 
        && !empty($_POST['contact_num']) 
        && !empty($_POST['username']) 
        && !empty($_POST['password'])
    ) { 


        $name            = $_POST['name'];
        $email           = $_POST['email'];
        $contact_num     = $_POST['contact_num'];
        $username        = $_POST['username'];

        $password        = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $target_dir      = "uploads/";
        $photo           = $_FILES['photo']['name'];
        $target_file     = $target_dir.basename($photo);
        $uploadOk        = 1;
        $imageFileType   = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $test_db = new Database("localhost", "root", "root", "API_ToDo_List");

        $sql = "INSERT INTO user_record(
					name, 
					email, 
					contact_num, 
					username, 
					password, 
					photo)
					VALUES(:namE, :emaiL, :contact_nuM, :usernamE, :passworD, :photO)";

        $prepare_stmt = $test_db->conn()->prepare($sql);
        $prepare_stmt->bindValue(':namE', $name);
        $prepare_stmt->bindValue(':emaiL', $email);
        $prepare_stmt->bindValue(':contact_nuM', $contact_num);
        $prepare_stmt->bindValue(':usernamE', $username);
        $prepare_stmt->bindValue(':passworD', $hashed_password);
        $prepare_stmt->bindValue(':photO', $photo);
        $execute = $prepare_stmt->execute();
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

        if ($execute) {
            echo '<span class="success">Record has been submitted!"</span>';
            $test_db = null;

        } else {
            echo '<span class="error">Record has not been submitted!"</span>' ;
        }
    } else {
        echo '<span class="error">Please enter all fields!</span>';
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
        <title>STCMediaBlog Registratrion</title>
        <link rel="stylesheet" type="text/css" href="include/style.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <!-- Latest compiled JavaScript -->
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
       </script>
       <style>
            div.reg_form
            {
                padding: 10px;
                width: 45%;
                margin: auto;
                background: lightgray;
                border-radius: 10px;
                box-shadow: 3px 3px 8px black;
            }
       </style>
    </head>
<body>
<!-- Beginning Of The NavBar-->
<nav class="navbar navbar-expand-md bg-dark navbar-dark mb-5">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php">STCMediaBlog CMS</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Service</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
     <li class="nav-item"><a href="login.php" class="nav-link text-success"> <i class="fas fa-user-times"></i> Log In</a></li>
    </ul>
  </div>
<!-- Beginning Of The Form For Button-->
<!--     <form class="form-inline" action="#">
    <input class="form-control mr-sm-2" type="text" placeholder="Search">
    <button class="btn btn-primary" type="submit">Search</button>
    </form>  --> 
</nav>
<div class="reg_form">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  class="dbform" method="POST" enctype="multipart/form-data">
<fieldset>
<span class="fieldinput">Name:</span>
<br>
<input type="text" name="name" value="
<?php if (isset($name)) {
    echo $name;
} ?>">
<br>
<span class="fieldinput">Email:</span>
<br>
<input type="text" name="email" value="
<?php if (isset($email)) {
    echo $email;
} ?>">
<br>
<span class="fieldinput">Contact Number:</span>
<br>
<input type="text" name="contact_num" value="
<?php if (isset($contact_num)) {
    echo $contact_num;
} ?>">
<br>
<span class="fieldinput">User Name:</span>
<br>
<input type="text" name="username" value="
<?php if (isset($username)) {
    echo $username;
} ?>">
<br>
<span class="fieldinput">Password:</span>
<br>
<input type="password" name="password" value="
<?php if (isset($password)) {
    echo $password;
} ?>">
<br>
<br>
<span class="fieldinput">Add Photo:</span>
<br>
<input type="file" name="photo" value="
<?php if (isset($photo)) {
    echo $photo;
} ?>">
<br>
<br>
<input type="submit" name="submit" value="Submit Record:">
</fieldset>
</form>
</div>

<hr>
<!-- FOOTER BEGIN -->
<div style="height: 10px;background-color: #f4f4f4;"></div>
<footer class="bg-dark text-white" id="load">
<div class="container">
<div class="row">
<div class="col">
<p class="lead text-center">&copy; www.RodneyStCloud.com All Rights Reserved &nbsp | <span id="demo_1" style="color: white;"><?php echo $date_time;?></span> </p>
</div>
</div>
</div>
</footer>
<div style="height: 10px;background-color: #f4f4f4;"></div>

</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html> 