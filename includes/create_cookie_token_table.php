<?php
/**
 * * @file
 * php version 8.2
 * Create Cookie Token Table Page for CMS
 * 
 * @category CMS
 * @package  Create_Cookie_Token_Table_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_cookie_token_table.php
 */
error_reporting(E_ALL);

require_once "db_conn.php"; 

$database = new Database("localhost", "root", "root", "cms");
$conn = $database->conn();

$sql = "CREATE TABLE cookie_token (
  id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(100) NOT NULL,
  token_key VARCHAR(255) NULL DEFAULT NULL,
  token_value VARCHAR(255) NULL DEFAULT NULL,
  token_datetime_expires_at VARCHAR(100) NULL DEFAULT NULL
  )";

$conn->exec($sql);
echo "Table cookie_token table has been created";
$conn = null;

