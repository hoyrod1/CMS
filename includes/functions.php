<?php
/**
 * * @file
 * php version 8.2
 * Functions Page for CMS
 * 
 * @category CMS
 * @package  Function_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/create_user_table.php
 */

require_once "includes/session.php";
require_once "db_conn.php";
require_once "includes/cookieToken.php";

//====================================================================//
/**
 * This function checks if the user exits in the database
 *
 * @param string $table   This has the approved comment table
 * @param string $post_id This has the POST ID
 * 
 * @access public  
 * 
 * @return mixed
 */
function approvedCommentCount($table, $post_id) 
{
    $conn       = new Database("localhost", "root", "root", "cms");
    $sql        = "SELECT COUNT(*) FROM $table 
                   WHERE comment_status = 'ON' AND post_id = $post_id";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}
//=====================================================================//

//=====================================================================//
/**
 * This function checks if the user exits in the database
 * 
 * @access public  
 * 
 * @return mixed
 */
function confirmLogin()
{
    $user_cookie = $_COOKIE["user"] ?? null;
    if (isset($_SESSION['user_name'])) {
        return true;
    } elseif ($user_cookie && strstr($user_cookie, ":")) {
        $token_parts  = explode(":", $user_cookie);
        $token_key    = $token_parts[0];
        $token_value  = $token_parts[1];
        $token_result = getCookieToken($token_key);
        if ($token_result) {
            $tokenValue = $token_result["token_value"];
            if ($token_value == $tokenValue) {
                return true;
            } else {
                $_SESSION['error_message'] = 'Please Login!';
                redirect('login.php');
            }
        }
    } else {
        $_SESSION['error_message'] = 'Please Login!';
        redirect('login.php');
    }
}
//=====================================================================//

//=====================================================================//
/**
 * This function checks if the user exits in the database
 *
 * @param string $table This has the attempted username
 * 
 * @access public  
 * 
 * @return mixed
 */
function dashboardCount($table) 
{
    $conn       = new Database("localhost", "root", "root", "cms");
    $sql        = "SELECT COUNT(*) FROM $table";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}
//=====================================================================//

//=====================================================================//
/**
 * This function checks if the user exits in the database
 *
 * @param string $table   This has the approved comment table
 * @param string $post_id This has the POST ID
 * 
 * @access public  
 * 
 * @return mixed
 */
function disapprovedCommentCount($table, $post_id) 
{
    $conn       = new Database("localhost", "root", "root", "cms");
    $sql        = "SELECT COUNT(*) FROM $table 
		           WHERE comment_status = 'off' AND post_id = $post_id";
    $stmt_count = $conn->conn()->query($sql);
    $execute    = $stmt_count->fetch();
    $row_count  = array_shift($execute);
    echo $row_count;
}
//=====================================================================//

//=====================================================================//
/**
 * The funtion returns the admin data if admin exist
 * 
 * @param string $username This param has the admin username submitted
 * 
 * @access public
 * 
 * @return mixed
 */
function getAdmin($username)
{
    $connect = new Database("localhost", "root", "root", "cms");
    $sql = "SELECT * FROM admin WHERE username = :username";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results;
}
//=====================================================================//

//=====================================================================//
/**
 * The funtion returns the user_record data if the user exist
 * 
 * @param string $username This param has the username submitted
 * 
 * @access public
 * 
 * @return mixed
 */
function getUserByUserName($username)
{
    $connect = new Database("localhost", "root", "root", "cms");
    $sql = "SELECT * FROM user_record WHERE username = :username";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results;
}
//=====================================================================//

//=====================================================================//
/**
 * The funtion returns the user_record data if the user exist
 * 
 * @param string $image_file This param contains the image file name
 * 
 * @access public
 * 
 * @return mixed
 */
function imageValidation($image_file) 
{
    // CODE TO UPLOAD IMAGE TO FILE AND IMAGE NAME TO DATA BASE //
    $target_dir      = "images/";
    $image           = $image_file;
    $target_file     = $target_dir.basename($image);
    $uploadOk        = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ------------- CODE TO VALIDATE IF THE IMAGE IS VALID -------------- //
    // define form data and image error array and set to empty values
    $photoErr        = [];
    // 1st CHECK TO SEE IF FILE EXIST ALREADY
    if (!preg_match("`^[-0-9A-Z_\. ]+$`i", $image)) {
        $photoErr[] = 1;
        $_SESSION['error_message'] = "Only english letters, numbers, dash, underscore and periods allowed";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        $photoErr[] = 2;
        $_SESSION['error_message'] = "Sorry, file already exists";
        $uploadOk = 0;
    }
    // 2nd CHECK FILE SIZE
    if ($_FILES["image"]["size"] > 900000) {
        $photoErr[] = 3;
        $_SESSION['error_message'] = "Sorry, your file is too large";
        $uploadOk = 0;
    }
    // 3rd CHECK TO SEE IF FILE FORMAT IS A jpg, jpeg, png, gif
    if ($image_file_type != "jpg" 
        && $image_file_type != "jpeg" 
        && $image_file_type != "png"
        && $image_file_type != "gif"
    ) {
        $photoErr[] = 4;
        $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        $uploadOk = 0;
    }
    // 4th Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $photoErr[] = 5;
        $photoErr[] = "Sorry, your file was not uploaded <br>";
    }

    if (!empty($photoErr)) {
        return false;
    } else {
        return $target_file;
    }


}
//=====================================================================//

//=====================================================================//
/**
 * This function checks if the user exits in the database
 *
 * @param string $username This has the attempted username
 * @param string $password This has the attempted password
 * 
 * @access public  
 * 
 * @return mixed
 */
function loginAttempt($username, $password)
{
    $connect = new Database("localhost", "root", "root", "cms");

    $sql_login = "SELECT * FROM admin 
                  WHERE username = :uSernAme AND password = :pAsswOrd LIMIT 1";
    $pre_login = $connect->conn()->prepare($sql_login);
    $pre_login->bindValue(':uSernAme', $username, PDO::PARAM_STR);    
    $pre_login->bindValue(':pAsswOrd', $password, PDO::PARAM_STR);
    $pre_login->execute();

    $execute_results  = $pre_login->rowcount();
    if ($execute_results == 1) {
        
        $user_account = $pre_login->fetch();
        return $user_account;

    } else {

        return null;
        
    }
}
//=====================================================================//

//=====================================================================//
/**
 * This function redirects the users url path
 *
 * @param string $new_url This has the url to rediected
 * 
 * @access public  
 * 
 * @return mixed
 */
function redirect($new_url)
{
    header("location:".$new_url);
    exit;
}
//=====================================================================//

//=====================================================================//
/**
 * This function sanatizes the form feilds
 *
 * @param string $data This has the users form input data
 * 
 * @access public  
 * 
 * @return mixed
 */
function testInput($data) 
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//=====================================================================//

//=====================================================================//
/**
 * This function checks if the user exits in the database
 *
 * @param string $username 
 * 
 * @access public  
 * 
 * @return mixed
 */
function usernameExist($username)
{
    $connect = new Database("localhost", "root", "root", "cms");

    $sql  = "SELECT username FROM admin WHERE username = :userName";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(':userName', $username, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->rowcount();
    if ($results == 1) {
        return true;
    } else {
        return false;
    }
}
//=====================================================================//
