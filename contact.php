<?php
/**
 * * @file
 * php version 8.2
 * Contact Page for CMS
 * 
 * @category CMS
 * @package  Contact_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/contact.php
 */

require "includes/date_time.php";

?>

<!------------------------ OPENING HTML TAGS AND NAV LINKS ------------------------>
      <?php 
        $title = "Contact Page";
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
                  <i class="contact_i fas fa-text-height"> 
                    STC Media CMS Contact Page
                  </i>
                </h1>
              </div>
            </div>
          </div>
        </header>
        <hr>
        <!------------------------------ HEADER ENDS ------------------------------>
        <!---------------------------- CONTAINER BEGINS --------------------------->
        <div class="contact_container">
          <h2 class="contact_h2 bg-secondary">
            Contact STC Media
          </h2>
          <p class="contact_p"> 
            If you have any questions or you are experiencing technical 
            difficulties Please email us at test@test.com. Also please
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