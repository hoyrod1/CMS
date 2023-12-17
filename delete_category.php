<?php 

require_once("includes/db_conn.php");
require_once("includes/functions.php");
require_once("includes/session.php");
require_once("includes/date_time.php");
//confirm_login();

if (isset($_GET['id'])) {
	
	$category_id = $_GET['id'];
	$admin_name  = $_SESSION['admin_name'];
	$connect     = new conn_cms;
	$sql         = "DELETE FROM category WHERE id = '$category_id'";
	$execute     = $connect->conn()->query($sql);

	if ($execute) 
	{
		$_SESSION['success_message'] = "Category has been deleted!";
		redirect('categories.php');
	}else
	{
		$_SESSION['error_message'] = "ERROR! Category was not deleted.";
		redirect('categories.php');
	}

}

?>