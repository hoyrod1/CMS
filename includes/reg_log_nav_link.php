<?php 
/**
 * * @file
 * php version 8.2
 * Unlogged Nav Link Page for CMS
 * 
 * @category CMS
 * @package  Unlogged_Nav_Link_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/incudes/unlogged_nav_link.php
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

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://kit.fontawesome.com/dfc9e3c3d1.js" crossorigin="anonymous"></script>
      <script type="text/javascript" src="javascript/js_script.js"></script>

      <!------------------- BEGINNING OF LOCAL STYLE FILES ---------------->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" type="text/css" href="css/index_style.css">
      <link rel="stylesheet" type="text/css" href="css/about_style.css">
      <link rel="stylesheet" type="text/css" href="css/contact_style.css">
      <link rel="stylesheet" type="text/css" href="css/feature_style.css">
      <link rel="stylesheet" type="text/css" href="css/service_style.css">
      <link rel="stylesheet" type="text/css" href="css/register_style.css">
      <!---------------------- ENDING OF FONT LINKS ----------------------->

    </head>
    <!-----------------------------------BODY BEGIN------------------------------------>
    <body style="background-color:#e3e8e4;">
    <!-------------------------------------NAV-BAR----------------------------------->
    <div style="height: 10px;background-color: #f4f4f4;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
          <div class="container">
            <?php
            if (isset($_SESSION["user_id"])) {
                echo '
                <a href="dashboard.php" class="navbar-brand">STC Media Blog</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a href="myprofile.php" class="nav-link">Home</a>
                  </li>';
            } else {
                echo '
                <a href="index.php" class="navbar-brand">STC Media Blog</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                  </li>';
            }
            ?>
              <li class="nav-item">
                <a href="about.php" class="nav-link">About</a>
              </li>
              <li class="nav-item">
                <a href="blog_post.php?page=1" class="nav-link">Blog</a>
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

                if ($title == "Registratrion Page") {
                    echo '
                        <li class="nav-item ml-5">
                          <a href="login.php" class="nav-link text-success"> 
                            <i class="fas fa-user-times"></i> Log In
                          </a>
                        </li>';
                } elseif ($title == "Login Page") {
                    echo '
                        <li class="nav-item ml-5">
                          <a href="register.php" class="nav-link text-success"> 
                            <i class="fa-solid fa-registered">Register</i>
                          </a>
                        </li>';
                } elseif (isset($_SESSION["user_id"])) {
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
          </div>
        </nav>
      <div style="height: 10px;background-color: #f4f4f4;"></div>
      <!---------------------------------NAV BAR END-------------------------------->


