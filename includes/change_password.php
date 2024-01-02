<?php
/**
 * * @file
 * php version 8.2
 * Change Password Page for CMS
 * 
 * @category CMS
 * @package  Change_Password_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/change_password.php
 */
require_once "session.php";
require_once "functions.php";
require_once "../includes/date_time.php";

if (!isset($_GET["token"])) {
    redirect('../reset_password.php');
}

require_once "db_conn.php";

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$connect    = new Database("localhost", "root", "root", "cms");

$sql        = "SELECT * FROM user_record WHERE reset_token  = :token_hash";
$stmt = $connect->conn()->prepare($sql);
$stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$results) {
    $_SESSION['error_message'] = "Token not found";
    redirect('../reset_password.php');
    $sql = null;
}

//-- CHECK TO IF THE reset_token_expire_at COLUMN IN THE DATABASE EXPIRED --//

$expeiration_time = strtotime($results["reset_token_expire_at"]);

if ($expeiration_time <= time()) {
    $_SESSION['error_message'] = "Your token has expired";
    redirect('../reset_password.php');
}

?>


<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="author" content="BooBoo">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Change Password</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/js_script.js"></script>

    </head>
    <body>
<!-- NAV-BAR BEGINS -->
    <div style="height: 10px;background-color: #f4f4f4;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
          <!-- Brand -->
          <div class="container">
            <a href="index.php" class="navbar-brand">STC Media Blog</a>
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
              <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a>
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
              <li class="nav-item">
                <a class="nav-link" href="#">Service</a>
              </li>
              <li class="nav-item ml-5">
                <a href="register.php" class="nav-link text-success"> 
                  <i class="fa-solid fa-registered">Register</i>
                </a>
              </li>
            </ul>
            <!-- Navbar links -->
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
      echo errorMessage(); 
      echo successMessage(); 
    ?><!-- NAME ERROR SHORT HAND IF STATEMENT -->
    <?php if (isset($emptyEmailErr)) :?> 
     <div style="width:300px;height:20px;margin:auto;color:red;font-weight: bold;"> <?php echo $emptyEmailErr; ?> </div> 
    <?php endif; ?>
    <?php if (isset($emailErr)) :?> 
     <div style="width:300px; height: 20px; margin: auto; color:red;font-weight: bold;"> <?php echo $emailErr; ?> </div> 
    <?php endif; ?>
    <br>
<!----------------------- MAIN AREA BEGINS --------------------------->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
      <div class="card bg-secondary text-light">
        <div class="card-header">
          <h1>Reset Password</h1>
        </div>
<!------------------------- FORM BEGINS ------------------------------>
<div class="card-body bg-dark">
  <form class="" action="process_reset_password.php" method="post">

    <div class="form-group">
      <label for="password">
        <span style="color: lightblue ;">New Password:</span>
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text text-white bg-info">
            <i class="fas fa-user"></i>
          </span>
        </div>
        <input type="password" name="password" class="form-control" id="password" value="">
      </div>
    </div>

    <div class="form-group">
      <label for="confirm_password">
        <span style="color: lightblue ;">Confirm Password:</span>
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text text-white bg-info">
            <i class="fas fa-user"></i>
          </span>
        </div>
        <input type="password" name="confirm_password" class="form-control" id="confirm_password">
      </div>
    </div>

        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <input type="submit" name="submit" class="btn btn-info btn-block" value="Reset Password">

  </form>

</div>
<!------------------------- FORM ENDS ------------------------------>
      </div>
    </div>
  </div>
</section>
<!----------------------- MAIN AREA ENDS --------------------------->
<hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "../includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
