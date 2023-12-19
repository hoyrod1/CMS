<?php
/**
 * * @file
 * php version 8.2
 * Login Page for CMS
 * 
 * @category CMS
 * @package  Login_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/login.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

$test_db = new Database("localhost", "root", "root", "cms");
$test = $test_db->conn();


if (isset($_SESSION['user_name'])) {
    redirect('dashboard.php');
}

if (isset($_POST['submit'])) {

    $username        = testInput($_POST['username']);
    $password        = testInput($_POST['password']);

    if (empty($username) || empty($password)) {

        $_SESSION['error_message'] = 'All fields should be filled out!';
        redirect('login.php');

    } else {

        $user_login = getUserByUserName($username);

        if ($user_login === false) {

            $_SESSION["error_message"] = 'Failed to login! The user does not exist';
            redirect('login.php');
        
        }

        $password_verified = password_verify($password, $user_login["password"]);

        if ($password_verified) {
            $_SESSION['user_id']         = $user_login['id'];
            $_SESSION['user_name']       = $user_login['username'];
            $_SESSION['admin_name']      = $user_login['name'];
            $_SESSION["success_message"] = 'Welcome ' . $_SESSION['user_name'];
            if (isset($_SESSION['trackingURL'])) {
                 redirect($_SESSION['trackingURL']);
            } else {
                 redirect('login.php');
            }
        } else {
            $_SESSION["error_message"] = 'Failed to login! Incorect Password.';
            redirect('login.php');
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
    <title>Login Page</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/js_script.js"></script>

    </head>
    <body>
<!-- NAV-BAR -->
    <div style="height: 10px;background-color: #f4f4f4;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container">

    <a href="index.php" class="navbar-brand">www.STCMediaBlog.com</a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
    <span class="navbar-toggler-icon"></span>
    </button>
<div class="collapse navbar-collapse" id="navbarcollapseCMS">

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
    <h1></h1>
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
    <br>
<!----------------------- MAIN AREA BEGINS --------------------------->
<section class="container py-2 mb-4">
<div class="row">
<div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
<div class="card bg-secondary text-light">
<div class="card-header">
<h1>Log in</h1>
</div>
<!------------------------- FORM BEGINS ------------------------------>
<div class="card-body bg-dark">
<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="form-group">
<label for="username"><span style="color: lightblue ;">User Name:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
</div>
<input type="text" name="username" class="form-control" id="username">
</div>
</div>
<div class="form-group">
<label for="password"><span style="color: lightblue ;">Password:</span></label>
<div class="input-group mb-3">
<div class="input-group-prepend">
<span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
</div>
<input type="password" name="password" class="form-control" id="password">
</div>
</div>
<input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
</form>
<div style="margin-top: 5px;"><a href="register.php">Register</a></div>
</div>
<!------------------------- FORM ENDS ------------------------------>
</div>
</div>
</div>
</section>
<!----------------------- MAIN AREA ENDS --------------------------->
<hr>
<!-- FOOTER BEGIN -->
<div style="height: 10px;background-color: #f4f4f4;"></div>
<footer class="bg-secondary text-white" id="load">
<div class="container">
<div class="row">
<div class="col">
<p class="lead text-center">&copy; www.RodneyStCloud.com All Rights Reserved &nbsp | 
<span id="demo_1" style="color: white;">
<?php echo $date_time;?>
</span>
</p>
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