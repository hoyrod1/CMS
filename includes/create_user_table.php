<?php
/**
 * * @file
 * php version 8.2
 * Create user_rec Table Page for CMS
 * 
 * @category CMS
 * @package  Database_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_user_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE user_record (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contact_num VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  photo VARCHAR(255) NOT NULL,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";

$conn->exec($sql);
echo "Table user_record has been created";
$conn = null;

