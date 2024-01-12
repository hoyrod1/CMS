<?php
/**
 * * @file
 * php version 8.2
 * Cookie Token Page for CMS
 * 
 * @category CMS
 * @package  Cookie_Token_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/cookieToken.php.php
 */
require_once "includes/session.php";
require_once "includes/db_conn.php";

//=====================================================================//
/**
 * The funtion inserts the users cookie token_key and token_value
 * 
 * @param int    $user_id     This param has the users id
 * @param string $token_key   This param has the users hashed token key
 * @param string $token_value This param has the users hashed token value
 * @param string $expiry_time This param has the cookies expiry time
 * 
 * @access public
 * 
 * @return mixed
 */
function setCookieToken($user_id, $token_key, $token_value, $expiry_time)
{
    $connect = new Database("localhost", "root", "root", "cms");
    $sql = "INSERT INTO cookie_token(user_id, 
                                     token_key, 
                                     token_value, 
                                     token_datetime_expires_at)
            VALUE(:id, :token_key, :token_value, :expiry_time)";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":token_key", $token_key, PDO::PARAM_STR);
    $stmt->bindValue(":token_value", $token_value, PDO::PARAM_STR);
    $stmt->bindValue(":expiry_time", $expiry_time, PDO::PARAM_STR);
    $results = $stmt->execute();
    return $results;
}
//=====================================================================//

//=======================================================================//
/**
 * The funtion verifies and retrieves the users cookie data if it exist
 * 
 * @param int $user_id This param has the users id
 * 
 * @access public
 * 
 * @return mixed
 */
function verifyTokenExist($user_id)
{
    $connect = new Database("localhost", "root", "root", "cms");
    $sql = "SELECT * FROM cookie_token WHERE user_id = :user_id";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results;
}
//=======================================================================//

//=======================================================================//
/**
 * The funtion retrieves the existing users cookie data
 * 
 * @param string $token_key This param has the users hashed token key
 * 
 * @access public
 * 
 * @return mixed
 */
function getCookieToken($token_key)
{
    $connect = new Database("localhost", "root", "root", "cms");
    $sql = "SELECT * FROM cookie_token WHERE token_key = :token_key LIMIT 1";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":token_key", $token_key, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results;
}
//=======================================================================//

//=======================================================================//
/**
 * The funtion verifies and retrieves the users cookie data if it exist
 * 
 * @param int    $user_id     This param has the users id
 * @param string $token_key   This param has the users hashed token key
 * @param string $token_value This param has the users hashed token value
 * @param string $expiry_time This param has the cookies expiry time
 * 
 * @access public
 * 
 * @return mixed
 */
function updateCookieToken($user_id, $token_key, $token_value, $expiry_time)
{
    $connect = new Database("localhost", "root", "root", "cms");
        $sql = "UPDATE cookie_token 
                SET token_key = :token_key, 
                    token_value = :token_value, 
                    token_datetime_expires_at = :expiry_time
                WHERE user_id = :user_id";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":token_key", $token_key, PDO::PARAM_STR);
    $stmt->bindValue(":token_value", $token_value, PDO::PARAM_STR);
    $stmt->bindValue(":expiry_time", $expiry_time, PDO::PARAM_STR);
    $results = $stmt->execute();
    return $results;
}
//=======================================================================//