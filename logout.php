<?php
/**
 * * @file
 * php version 8.2
 * Logout Page for CMS login
 * 
 * @category CMS
 * @package  Logout_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/www.logout.php
 */
require_once "includes/session.php";
require_once "includes/functions.php";
require_once "includes/cookieToken.php";
require_once "includes/date_time.php";

$_SESSION['user_id']      = null;
$_SESSION['user_name']    = null;
$_SESSION['admin_name']   = null;

session_destroy();

redirect('login.php');
