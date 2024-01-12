<?php
/**
 * * @file
 * php version 8.2
 * Set Login Cookies Page for CMS
 * 
 * @category CMS
 * @package  Set_Login_Cookies_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/set_login_cookies.php.php
 */
require_once "includes/cookieToken.php";
//=======================================================================//
/**
 * This funtion sets the users cookie data
 * 
 * @param string $user_id This param has the users id
 * 
 * @access public
 * 
 * @return mixed
 */
function setLoginCookie($user_id)
{
    // INSERT ENCRYPTED COOKIE VALUE INTO "cookie_token" TABLE //
    $salt        = "@#&sAlT"; // pt 1 encryption
    $token_key   = hash("sha256", (time().$salt)); // pt 2 encryption
    $token_value = hash("sha256", ("loggeg_in".$salt)); // pt 3 encryption
    // INSERT EXPIRATION TIME INTO "cookie_token" TABLE //
    $expiry_time = 60*60*24*7; //cookie expiration time
    $setCookieToken = setCookieToken($user_id, $token_key, $token_value, $expiry_time);
    // if ($setCookieToken) {
    //     echo "Cookie Table has be inserted";
    //     exit;
    // }
    // SET COOKIE AFTER SUCCESSFULLY LOGGING IN //
    setcookie("user", $token_key.":".$token_value, time()+$expiry_time);
}
//=======================================================================//

//=======================================================================//
/**
 * This funtion sets the users cookie data
 * 
 * @param string $user_id This param has the users id
 * 
 * @access public
 * 
 * @return mixed
 */
function updateLoginCookie($user_id)
{
    // UPDATE ENCRYPTED COOKIE VALUE INTO "cookie_token" TABLE //
    $salt        = "@#&sAlT"; // pt 1 encryption
    $token_key   = hash("sha256", (time().$salt)); // pt 2 encryption
    $token_value = hash("sha256", ("loggeg_in".$salt)); // pt 3 encryption
    // UPDATE EXPIRATION TIME INTO "cookie_token" TABLE //
    $expiry_time = 60*60*24*7; //cookie expiration time
    $updateCookieToken = updateCookieToken($user_id, $token_key, $token_value, $expiry_time);
    // if ($updateCookieToken) {
    //     echo "Cookie Table has be inserted";
    //     exit;
    // }
    // SET COOKIE AFTER SUCCESSFULLY LOGGING IN //
    setcookie("user", $token_key.":".$token_value, time()+$expiry_time);
}
//=======================================================================//