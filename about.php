<?php
/**
 * * @file
 * php version 8.2
 * About Page for CMS
 * 
 * @category CMS
 * @package  About_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/about.php
 */

require "includes/date_time.php";

?>

<!------------------------ OPENING HTML TAGS AND NAV LINKS ------------------------>
      <?php 
        $title = "About Page";
        require_once "includes/unlogged_nav_link.php"; 
        ?>
<!------------------------ CLOSING HTML TAGS AND NAV LINKS ------------------------>

        <!------------------------------ HEADER BEGINS ----------------------------->
        <hr>
        <header class="bg-dark text-white py-3">
          <div class="container">
            <div class="row">
              <div class="col-md-12 ">
                <h1>
                  <i class="about_i fas fa-text-height"> 
                    STC Media CMS About Page
                  </i>
                </h1>
              </div>
            </div>
          </div>
        </header>
        <hr>
        <!------------------------------ HEADER ENDS ------------------------------>
        <!---------------------------- CONTAINER BEGINS --------------------------->
        <div class="about_container">
          <h2 class="about_h2 bg-secondary">
            Details about the STC Media CMS Blog Website
          </h2>
          <p class="about_p"> 
            We are currently in develpoement of this CMS system. Please 
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