<?php
/**
 * * @file
 * php version 8.2
 * Create category Table Page for CMS
 * 
 * @category CMS
 * @package  Database_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_category_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE category (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  author VARCHAR(100) NOT NULL,
  date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

$conn->exec($sql);
echo "Table user_record has been created";
$conn = null;

