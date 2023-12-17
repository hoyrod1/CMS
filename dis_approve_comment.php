<?php 

require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");
//confirm_login();

if (isset($_GET['id'])) {
	
	$com_id = $_GET['id'];
	$admin_name = $_SESSION['admin_name'];
	$connect   = new conn_cms;
	$sql        = "UPDATE comments SET comment_status = 'off', approved_by = '$admin_name' WHERE id = '$com_id'";
	$execute    = $connect->conn()->query($sql);

	if ($execute) 
	{
		$_SESSION['success_message'] = "Comment has been dis-approved successfully!";
		redirect('comments.php');
	}else
	{
		$_SESSION['error_message'] = "ERROR! Comment was not dis-approved.";
		redirect('comments.php');
	}

}

?>