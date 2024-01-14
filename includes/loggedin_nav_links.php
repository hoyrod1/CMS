<?php
/**
 * * @file
 * php version 8.2
 * Nav_Links for CMS
 * 
 * @category CMS
 * @package  Nav_Links
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/incudes/nav_links.php
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
<!-- BODY AREA BEGINS-->
<body>
<!-- NAV-BAR -->
<div style="height: 10px;background-color: #f4f4f4;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <div class="container">
      <a href="myprofile.php" class="navbar-brand">STC Media Blog</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                  <a href="myprofile.php" class="nav-link">
                      <i class="fas fa-user text-success"></i> My Profile
                  </a>
              </li>
              <li class="nav-item">
                  <a href="dashboard.php" class="nav-link">Dashboard</a>
              </li>
              <li class="nav-item">
                  <a href="post.php" class="nav-link">Post</a>
              </li>
              <li class="nav-item">
                  <a href="categories.php" class="nav-link">Categories</a>
              </li>
              <li class="nav-item">
                  <a href="admin.php" class="nav-link">Manage Admins</a>
              </li>
              <li class="nav-item">
                  <a href="comments.php" class="nav-link">Comments</a>
              </li>
              <li class="nav-item">
                  <a href="blog_post.php?page=1" class="nav-link">Live Blog</a>
              </li>
               <li class="nav-item ml-5">
                   <a href="logout.php" class="nav-link text-danger">
                       <i class="fas fa-user-times"></i> Log Out
                   </a>
              </li>
           </ul>
      </div>
   </div>
</nav>
<div style="height: 10px;background-color: #f4f4f4;"></div>