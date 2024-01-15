<?php
/**
 * * @file
 * php version 8.2
 * Create Blog Email Table Page for CMS
 * 
 * @category CMS
 * @package  Create_Blog_Email_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_blog_email.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE blog_email (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) NOT NULL,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

$conn->exec($sql);
echo "Table blog_email has been created";
$conn = null;

