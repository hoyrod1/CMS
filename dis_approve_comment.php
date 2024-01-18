<?php
/**
 * * @file
 * php version 8.2
 * Dis Approve Comment Page for CMS
 * 
 * @category CMS
 * @package  Dis_Approve_Comment_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/dis_approve_comments.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin();
//------- SET $adminName TO SESSION OR COOKIE ADMIN NAME -------//
$admin_name = "";
if (isset($_SESSION["admin_name"])) {
    $admin_name = $_SESSION["admin_name"];
} elseif (isset($_COOKIE["admin_name"])) {
    $admin_name = $_COOKIE["admin_name"];
}
//--------------------------------------------------------------//
$com_id = $_GET['id'];

if (isset($com_id)) {
    
    $connect    = new Database("localhost", "root", "root", "cms");
    $sql        = "UPDATE comments 
                   SET comment_status = 'off', 
                   approved_by = :admin_name 
				   WHERE id = :com_id";
    $pre_stmt = $connect->conn()->prepare($sql);
    $pre_stmt->bindValue(':com_id', $com_id);
    $pre_stmt->bindValue(':admin_name', $admin_name);
    $execute = $pre_stmt->execute();

    if ($execute) {
        $_SESSION['success_message'] = "Comment has been dis-approved successfully!";
        redirect('comments.php');
    } else {
        $_SESSION['error_message'] = "ERROR! Comment was not dis-approved.";
        redirect('comments.php');
    }

}

?>