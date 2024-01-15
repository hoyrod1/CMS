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

$com_id = $_GET['id'];
$admin_name = $_SESSION['admin_name'];

if (isset($com_id)) {
    
    $connect    = new Database("localhost", "root", "root", "cms");
    $sql        = "UPDATE comments 
	               SET comment_status = 'ON', 
                   approved_by = '$admin_name' 
				   WHERE id = :com_id";
    $pre_stmt = $connect->conn()->prepare($sql);
    $pre_stmt->bindValue(':com_id', $com_id);
    $execute = $pre_stmt->execute();

    if ($execute) {
        $_SESSION['success_message'] = "Comment has been approved";
        redirect('comments.php');
    } else {

        $_SESSION['error_message'] = "Comment was not approved";
        redirect('comments.php');
    }

} else {
    $_SESSION['error_message'] = "Not allowed to perform this action";
    redirect('comments.php');
}
