<?php
/**
 * * @file
 * php version 8.2
 * Feature Page for CMS
 * 
 * @category CMS
 * @package  Contact_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/feature.php
 */
require_once "includes/session.php";
require "includes/date_time.php";

?>

<!------------------------ OPENING HTML TAGS AND NAV LINKS ------------------------>
      <?php 
        $title = "Feature Page";
        require_once "includes/links/reg_log_nav_link.php"; 
        ?>
<!------------------------ CLOSING HTML TAGS AND NAV LINKS ------------------------>

        <!------------------------------ HEADER BEGINS ----------------------------->
        <hr>
        <header class="bg-light text-white py-3">
          <div class="container">
            <div class="row">
              <div class="col-md-12 ">
                <h1>
                  <i class="feature_i fas fa-text-height text-info"> 
                    STC Media CMS Feature Page
                  </i>
                </h1>
              </div>
            </div>
          </div>
        </header>
        <hr>
        <!------------------------------ HEADER ENDS ------------------------------>
        <!---------------------------- CONTAINER BEGINS --------------------------->
        <div class="feature_container">
          <h2 class="feature_h2 bg-secondary">
            STC Media CMS Features
          </h2>
          <p class="feature_p"> 
            We will feature the many unique and motivating Features
            that will make our web site worth coming back to. In order
            to witness all of the amazing features please 
            <a href="register.php">register</a> to STC Media Inc Blog in
            order to benefit from years of experience in life.
          </p>
       </div>
        <!----------------------------- CONTAINER ENDS ---------------------------->
       <hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html>