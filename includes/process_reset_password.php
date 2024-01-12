<?php
/**
 * * @file
 * php version 8.2
 * Process Reset Password Page for CMS
 * 
 * @category CMS
 * @package  Process_Reset_Password_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/process_reset_password.php
 */
require_once "session.php";
require_once "functions.php";
require_once "../includes/date_time.php";

require_once "db_conn.php";

//-------------------------------------------------------------------//
$token      = $_POST["token"];
$token_hash = hash("sha256", $token);

$connect    = new Database("localhost", "root", "root", "cms");


$sql        = "SELECT * FROM user_record WHERE reset_token = :token_hash";
$stmt = $connect->conn()->prepare($sql);
$stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$time = time();

// echo "<pre>";
// var_dump($results);
// echo "</pre>";
// exit;

if (!$results) {
    $_SESSION['error_message'] = "Token not found";
    redirect('../reset_password.php');
    $sql = null;
}

//-- CHECK TO IF THE reset_token_expire_at COLUMN IN THE DATABASE EXPIRED --//
$expeiration_time = strtotime($results["reset_token_expire_at"]);

if ($expeiration_time <= time()) {
    $_SESSION['error_message'] = "Your token has expired";
    redirect('../reset_password.php');
}
//-------------------------------------------------------------------//

//-------------------------------------------------------------------//

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE user_record 
        SET password = :new_password, 
        reset_token = :nul1, reset_token_expire_at = :nul2 
        WHERE id = :id";
$stmt = $connect->conn()->prepare($sql);
$stmt->bindValue(':new_password', $hashed_password, PDO::PARAM_STR);
$stmt->bindValue(':nul1', null);
$stmt->bindValue(':nul2', null);
$stmt->bindValue(':id', $results["id"], PDO::PARAM_STR);
$new_results = $stmt->execute();

if (!$new_results) {
    $_SESSION['error_message'] = "There was a error";
    redirect('../reset_password.php');
    $sql = null;
} else {
    $_SESSION['success_message'] = "Password changed successfully";
    redirect('../login.php');
    $sql = null;
}