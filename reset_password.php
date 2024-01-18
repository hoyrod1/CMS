<?php
/**
 * * @file
 * php version 8.2
 * Reset Password Page for CMS
 * 
 * @category CMS
 * @package  Reset_Password_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/reset_password.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";
require_once "includes/send_password_reset.php";
require_once "mailer.php";

// define $_POST variables and set to empty values
$email = "";

// define error variables and set to empty values
// $emptyEmailErr = "";
// $emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    if (empty($_POST["email"])) {
        $emptyEmailErr = "Email is required";
        
    } else {
        $email = testInput($_POST['email']);
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $verify_email = verifyEmail($email);
            if ($verify_email === false) {
                $_SESSION['error_message'] = "Users email, $email, doesn't exist";
            } else {
                $reset_email_result = resetEmail($email);
                if ($reset_email_result === false) {
                    $_SESSION['error_message'] = "Something went wrong, try again";
                } else {
                    $_SESSION['success_message'] = "Check email to reset password";
                }
            }
        }
    }
}

?>

    <!---------------------- OPENING HTML TAGS AND NAV LINKS --------------------->
    <?php 
      $title = "Reset Password";
      require_once "includes/links/reset_email_nav_link.php"; 
    ?>
    <!---------------------- CLOSING HTML TAGS AND NAV LINKS --------------------->
    <!-------------------------------- NAV BAR END-------------------------------->
    <hr>
    <!-- HEADER BEGINS-->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 ">
            <h1 style="text-align: center;">
              <i class="index_i fas fa-text-height text-info"> 
                  Welcome to STC Media Reset Password Page
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
  <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="form-group">
      <label for="userEmail">
        <span style="color: lightblue ;">Email:</span>
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text text-white bg-info">
            <i class="fas fa-user"></i>
          </span>
        </div>
        <input type="text" name="email" class="form-control" id="userEmail">
      </div>
    </div>

    <input type="submit" name="submit" class="btn btn-info btn-block" value="Login">

  </form>

  <div style="margin-top:10px;"><a href="login.php" style="color: #28a745;margin-top:15px;">Login</a></div>

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