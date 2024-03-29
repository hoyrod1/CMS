<?php
/**
 * * @file
 * php version 8.2
 * Create Admin Table Page for CMS
 * 
 * @category CMS
 * @package  Create_Admin_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_admin_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE admin (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  admin_name VARCHAR(100) NOT NULL,
  added_by VARCHAR(100) NOT NULL,
  admin_headline VARCHAR(100) NULL DEFAULT 'Please add a headline',
  admin_bio VARCHAR(255) NULL DEFAULT 'Please add a headline',
  admin_photo VARCHAR(255) NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  )";

$conn->exec($sql);
echo "Table user_record has been created";
$conn = null;

