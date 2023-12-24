<?php
/**
 * * @file
 * php version 8.2
 * service Page for CMS
 * 
 * @category CMS
 * @package  Service_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/service.php
 */

require "includes/date_time.php";

?>

<!------------------------ OPENING HTML TAGS AND NAV LINKS ------------------------>
      <?php 
        $title = "Service Page";
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
                  <i class="service_i fas fa-text-height"> 
                    STC Media CMS Blog Service Page
                  </i>
                </h1>
              </div>
            </div>
          </div>
        </header>
        <hr>
        <!------------------------------ HEADER ENDS ------------------------------>
        <!---------------------------- CONTAINER BEGINS --------------------------->
        <div class="service_container">
          <h2 class="service_h2 bg-secondary">
            STC Media CMS Services
          </h2>
          <p class="service_p"> 
            We will provide the services required to benifit all of the 
            many registered users of our CMS Blog system. In order to 
            benefit our services please <a href="register.php">register</a> 
            to STC Media Inc Blog in order to benefit from years of 
            experience in life.
          </p>
       </div>
        <!----------------------------- CONTAINER ENDS ---------------------------->
       <hr>

<!----BEGINNING FOOTER AND BODY SECTION---->
<?php require_once "includes/footer.php"; ?>
<!-----ENDING FOOTER AND BODY SECTION------>
</html>