<?php
/**
 * * @file
 * php version 8.2
 * Session Page for CMS registration
 * 
 * @category CMS
 * @package  Session_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/incudes/session.php
 */
session_start();

//=====================================================================//
/**
 * This function returns a session error message
 * 
 * @access public  
 * 
 * @return mixed
 */
function errorMessage()
{
    if (isset($_SESSION['error_message'])) {

        $error_message = "<div style=\"width: 535px;margin: auto;\" align=\"center\" class=\"alert alert-danger\">";
        $error_message .= htmlentities($_SESSION['error_message']);
        $error_message .= "</div>";

        $_SESSION['error_message'] = null;
        return $error_message;
    }
}
//=====================================================================//

//=====================================================================//
/**
 * This function returns a session success message
 * 
 * @access public  
 * 
 * @return mixed
 */
function successMessage()
{
    if (isset($_SESSION["success_message"])) {

        $success_message = "<div style=\"width: 535px;margin: auto;\" align=\"center\" class=\"alert alert-success\">";
        $success_message .= htmlentities($_SESSION["success_message"]);
        $success_message .= "</div>";

        $_SESSION["success_message"] = null;
        return $success_message;
    }
}
//=====================================================================//