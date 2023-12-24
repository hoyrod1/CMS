<?php 
/**
 * * @file
 * php version 8.2
 * Delete Admin Page for CMS registration
 * 
 * @category CMS
 * @package  Delete_Admin_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/delete_admin.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin();

if (isset($_GET['id'])) {

    $admin_id = $_GET['id'];
    $admin_name  = $_SESSION['admin_name'];
    $connect     = new Database("localhost", "root", "root", "cms");
    $sql         = "DELETE FROM admin WHERE id = '$admin_id'";
    $execute     = $connect->conn()->query($sql);

    if ($execute) {

        $_SESSION['success_message'] = "Admin has been deleted!";
        redirect('admin.php');
    } else {

        $_SESSION['error_message'] = "ERROR! Admin was not deleted.";
        redirect('admin.php');
    }

}