<?php
/**
 * * @file
 * php version 8.2
 * Create Post Table Page for CMS
 * 
 * @category CMS
 * @package  Create_Post_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_post_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE post (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  title VARCHAR(100) NOT NULL,
  category VARCHAR(100) NOT NULL,
  author VARCHAR(100) NOT NULL,
  image VARCHAR(255) NOT NULL,
  post TEXT NOT NULL
  )";

$conn->exec($sql);
echo "Table user_record has been created";
$conn = null;

