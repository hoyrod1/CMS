<?php
/**
 * * @file
 * php version 8.2
 * Index Page for CMS
 * 
 * @category CMS
 * @package  Index_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/index.php
 */
require "includes/set_cms_cookies.php";
require "includes/date_time.php";

?>

<!------------------------ OPENING HTML TAGS AND NAV LINKS ------------------------>
      <?php 
        $title = "Home Page";
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
                  <i class="index_i fas fa-text-height text-info"> 
                    Welcome to STC Media CMS Home Page
                  </i>
                </h1>
              </div>
            </div>
          </div>
        </header>
        <hr>
        <!------------------------------ HEADER ENDS ------------------------------>
        <!---------------------------- CONTAINER BEGINS --------------------------->
        <div class="index_container">
          <h2 class="index_h2 bg-secondary">
            Please register to our blog
          </h2>
          <p class="index_p"> 
            If you want to share your thought and experiences about your life please 
            <a href="register.php">register</a> to STC Media Inc Blog. You will be 
            able to upload photos from your experience to show the world. 
            You will be able to leave comments on the pictures.
            <?php
              echo "<pre>"; var_dump($_COOKIE); echo "</pre>";
              // echo "<br>";
              // echo $_COOKIE["visits"];
              // echo "<br>";
              // echo $_COOKIE["entryDateTime"];
              // echo "<br>";
              // echo $_COOKIE["entryPage"];
              // echo "<br>";
              // echo $_COOKIE["cameFrom"];
            ?>
          </p>
       </div>
        <!----------------------------- CONTAINER ENDS ---------------------------->
       <hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html>