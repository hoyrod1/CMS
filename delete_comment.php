<?php
/**
 * * @file
 * php version 8.2
 * Approve Comments Page for CMS
 * 
 * @category CMS
 * @package  Approve_Comments_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/approve_comments.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin(); 

if (isset($_GET['id'])) {

    $com_id     = $_GET['id'];
    $admin_name = $_SESSION['admin_name'];
    $connect    = new Database("localhost", "root", "root", "cms");
    $sql        = "DELETE FROM comments WHERE id = '$com_id'";
    $execute    = $connect->conn()->query($sql);

    if ($execute) {
        $_SESSION['success_message'] = "Comment has been deleted!";
        redirect('comments.php');
    } else {
        $_SESSION['error_message'] = "ERROR! Comment was not deleted.";
        redirect('comments.php');
    }

}

?>