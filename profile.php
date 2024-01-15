<?php 
/**
 * * @file
 * php version 8.2
 * Profile Post Page for CMS
 * 
 * @category CMS
 * @package  Profile_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/profile.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

//BEGINNING OF FETCHING EXISTING ADMIN DATA
$admin_name      = $_GET["admin_name"];

$profile_connect = new Database("localhost", "root", "root", "cms");
$profile_sql     = "SELECT admin_name, admin_headline, admin_bio, admin_photo 
                    FROM admin WHERE admin_name = :admin_name";
$profile_stmt    = $profile_connect->conn()->prepare($profile_sql);
$profile_stmt->bindValue(':admin_name', $admin_name);
$profile_stmt->execute();
$profile_results = $profile_stmt->rowcount();

if ($profile_results == 1) {

    while ($profile_row = $profile_stmt->fetch()) {
        $profile_name        = $profile_row['admin_name'];
        $profile_photo       = $profile_row['admin_photo'];
        $profile_title       = $profile_row['admin_headline'];
        $profile_bio         = $profile_row['admin_bio'];
    }

} else {
    $_SESSION["error_message"] = "There was a bad input!";
    redirect('blog_post.php?page=1');
}
//ENDING OF FETCHING EXISTING ADMIN DATA

//------------------- BEGINNING OF HTML/NAV SECTION --------------------------//
$title = "Profile Page";
require_once "includes/reg_log_nav_link.php"; 
//----------------------------------------------------------------------------//
?>
<hr>
  <?php 
    echo errorMessage();
    echo successMessage();
    ?>
    <!-- HEADER BEGINS-->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6 ">
            <h1>
              <i class="fas fa-user mr-2 text-success mr-2"> 
                <?php echo htmlentities($profile_name); ?> 
              </i>
            </h1>
            <p><?php echo htmlentities($profile_title); ?></p>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER ENDS-->
    <hr>
    <!-- MAIN AREA BEGIN -->
    <section class="container py-2 mb-4">
      <div class="row">
        <div class="col-md-3">
          <img src="<?php echo 'images/'.htmlentities($profile_photo); ?>" class="d-block img-fluid pb-3 m-auto rounded-circle" alt="Author of the blog" height="200px" width="190px">
          <a href="blog_post.php?page=1" class="text-white">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-3 rounded-circle" name="button">
              Return to the blog
            </button>
          </a>
        </div>
        <div class="col-md-9" style="min-height: 400px;">
          <div class="card">
            <div class="card-body">
              <p class="lead"><?php echo htmlentities($profile_bio); ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- MAIN AREA ENDS-->
<hr>
<!----------BEGINNING FOOTER SECTION----------->
<?php require_once "includes/footer.php"; ?>
<!----ENDING FOOTER SECTION AND END OF BODY---->
</html>