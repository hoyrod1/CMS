<?php
/**
 * * @file
 * php version 8.2
 * Create Comments Table Page for CMS
 * 
 * @category CMS
 * @package  Database_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_comments_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE comments (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  name VARCHAR(10) NOT NULL,
  email VARCHAR(100) NOT NULL,
  comment VARCHAR(100) NOT NULL,
  approved_by VARCHAR(10) NOT NULL,
  comment_status VARCHAR(10) NOT NULL,
  post VARCHAR(100) NOT NULL
  )";

$conn->exec($sql);
echo "Table user_record has been created";
$conn = null;

