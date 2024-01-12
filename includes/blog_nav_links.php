<?php
/**
 * * @file
 * php version 8.2
 * Unlogg_Nav_Links for CMS
 * 
 * @category CMS
 * @package  Unlogg_Nav_Links_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/unlogg_nav_links.php
 */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="BooBoo">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title><?php echo $title; ?></title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script type="text/javascript" src="javascript/js_script.js"></script>
</head>
<body>
  <!-- NAV-BAR -->
  <div style="height: 10px;background-color: #f4f4f4;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container">
      <a href="myprofile.php" class="navbar-brand">STC media Blog</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="about.php" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="blog_post.php" class="nav-link">Blog</a>
          </li>
          <li class="nav-item">
            <a href="contact.php" class="nav-link">Contact</a>
          </li>
          <li class="nav-item">
            <a href="feature.php" class="nav-link">Feature</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="service.php">Service</a>
          </li>
          <?php
            if (isset($_SESSION["user_id"])) {
                echo '
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link text-danger">
                                <i class="fas fa-user-times"></i> Log Out
                            </a>
                        </li>
                    </ul>';
            } else {
                echo '
                    <li class="nav-item ml-5">
                      <a href="login.php" class="nav-link text-success"> 
                        <i class="fas fa-user-times"></i> Log In
                      </a>
                    </li>';
            }
            ?>
        </ul>
        <!-- BEGINNING OF SEARCH FIELD-->
        <ul style="margin-top: 15px;">
          <form class="form-inline d-none d-sm-block" action="search_post.php" method="" enctype="">
           <div class="form-group">
             <input class="form-control mr-2" type="text" name="search" placeholder="Type search..." required>
             <button class="btn btn-primary" name="search_button">Search</button>
           </div>
         </form>
       </ul>
       <!-- ENDING OF SEARCH FIELD-->
      </div>
    </div>
  </nav>
  <div style="height: 10px;background-color: #f4f4f4;"></div>
  <!-- NAV BAR END-->