<?php
/**
 * * @file
 * php version 8.2
 * Admin Page for CMS registration
 * 
 * @category CMS
 * @package  Admin_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/delete_category.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";
require_once "includes/functions.php";
require_once "includes/date_time.php";

confirmLogin();

if (isset($_GET['id'])) {

    $category_id = $_GET['id'];
    $admin_name  = $_SESSION['admin_name'];
    $connect     = new Database("localhost", "root", "root", "cms");
    $sql         = "DELETE FROM category WHERE id = :category_id";
    $pre_stmt = $connect->conn()->prepare($sql);
    $pre_stmt->bindValue(':category_id', $category_id);
    $execute = $pre_stmt->execute();

    if ($execute) {

        $_SESSION['success_message'] = "Category has been deleted!";
        redirect('categories.php');
    } else {

        $_SESSION['error_message'] = "ERROR! Category was not deleted.";
        redirect('categories.php');
    }

}