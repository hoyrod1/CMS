<?php
/**
 * * @file
 * php version 8.2
 * Login Page for CMS
 * 
 * @category CMS
 * @package  Login_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/login.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/cookieToken.php";
require_once "includes/login_cookies.php";
require_once "includes/date_time.php";

$test_db = new Database("localhost", "root", "root", "cms");
$test = $test_db->conn();

if (isset($_SESSION['user_name'])) {
    redirect('dashboard.php');
    $_SESSION["success_message"] = $_SESSION['admin_name'] . ' you are already logged in';
}

if (isset($_POST['submit'])) {

    $username        = testInput($_POST['username']);
    $password        = testInput($_POST['password']);

    if (empty($username) || empty($password)) {

        $_SESSION['error_message'] = 'All fields should be filled out!';
        redirect('login.php');

    } else {
        // VERIFY ADMIN EXIST WITH THE USERNAME GIVEN //
        $admin_login = getAdmin($username);

        if ($admin_login === false) {

            $_SESSION["error_message"] = 'Failed to login! The user does not exist';
            redirect('login.php');
        
        }
        // VERIFY THE PASSWORD GIVEN //
        $password_verified = password_verify($password, $admin_login["password"]);

        if ($password_verified) {

            // SET SESSION VARIABLES AFTER SUCCESSFULLY LOGGING IN //
            $_SESSION['user_id']         = $admin_login['id'];
            $_SESSION['user_name']       = $admin_login['username'];
            $_SESSION['admin_name']      = $admin_login['admin_name'];
            $_SESSION["success_message"] = 'Welcome ' . $_SESSION['admin_name'];
            
            // IF REMEBER ME HAS BEEN SELECTED CREATE A COOKIE FOR USER //
            // USERS COOKIE DATA WILL BE STORED IN THE "cookie_token TABLE" //
            if (isset($_POST['remember'])) {

                // SET EXPIRATION TIME FOR COOKIE STORING THE "admin id" //
                $expiry_time = 60*60*24*7;

                // INSERT USERS ID INTO "cookie_token" TABLE //
                $admin_id   = $admin_login['id'];
                $admin_name = $admin_login['admin_name'];
                
                // CHECK IF COOKIE HAS ALREADY BEEN SET//
                $verify_cookie = verifyTokenExist($admin_id);
                if ($verify_cookie) {
                    // UPDATE COOKIE AND COOKIE DATA IN "cookie_token" TABLE //
                    updateLoginCookie($admin_id);
                    // SET COOKIE WITH ADMIN ID //
                    setcookie("admin_id", $admin_id, time()+$expiry_time);
                    // SET COOKIE WITH ADMIN NAME //
                    setcookie("admin_name", $admin_name, time()+$expiry_time);
                } else {
                    // SET COOKIE AND INSERT COOKIE DATA IN "cookie_token" TABLE //
                    setLoginCookie($admin_id);
                    // SET COOKIE WITH ADMIN ID //
                    setcookie("admin_id", $admin_id, time()+$expiry_time);
                    // SET COOKIE WITH ADMIN NAME //
                    setcookie("admin_name", $admin_name, time()+$expiry_time);
                }
            }

            if (isset($_SESSION['trackingURL'])) {
                 redirect($_SESSION['trackingURL']);
            } else {
                $name = $_SESSION['admin_name'];
                redirect("profile.php?admin_name=$name");
            }
        } else {
            $_SESSION["error_message"] = 'Failed to login! Incorect Password.';
            redirect('login.php');
        }
    }
}

//---------------------- OPENING HTML TAGS AND NAV LINKS ---------------------//
  $title = "Login Page";
  require_once "includes/links/reg_log_nav_link.php"; 
//---------------------- CLOSING HTML TAGS AND NAV LINKS ---------------------//

?>

<hr>
<!-- HEADER BEGINS-->
<header class="bg-light text-white py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
        <h1 style="text-align: center;">
          <i class="about_i fas fa-text-height text-info"> 
            STC Media CMS Login Page
          </i>
        </h1>
      </div>
    </div>
  </div>
</header>
<!-- HEADER ENDS-->
    <hr>
    <?php 
    echo errorMessage(); 
    echo successMessage(); 
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
      <label for="username">
        <span style="color: lightblue ;">User Name:</span>
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text text-white bg-info">
            <i class="fas fa-user"></i>
          </span>
        </div>
        <input type="text" name="username" class="form-control" id="username" required>
      </div>
    </div>

    <div class="form-group">
      <label for="password">
        <span style="color: lightblue ;">Password:</span>
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text text-white bg-info">
            <i class="fas fa-lock"></i>
          </span>
        </div>
        <input type="password" name="password" class="form-control" id="password" required>
      </div>
    </div>

    <input type="submit" name="submit" class="btn btn-info btn-block" value="Login">

    <label style="margin-top: 10px;">
        <input type="checkbox" name="remember"> Remember me
    </label>
  </form>
  <div><a href="reset_password.php" style="color: #17a2b8;">Forgot password</a></div>
</div>
<!------------------------- FORM ENDS ------------------------------>
      </div>
    </div>
  </div>
</section>
<!----------------------- MAIN AREA ENDS --------------------------->
<hr>
<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>