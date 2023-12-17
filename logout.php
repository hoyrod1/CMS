<?php 
	require_once("includes/functions.php");
	require_once("includes/session.php");
	require_once("includes/date_time.php");

	$_SESSION['user_id']      = null;
	$_SESSION['user_name']    = null;
	$_SESSION['admin_name']   = null;
	session_destroy();
	redirect('login.php');
?>