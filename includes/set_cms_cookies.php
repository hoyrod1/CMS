<?php
/**
 * * @file
 * php version 8.2
 * Cookies Page for CMS
 * 
 * @category CMS
 * @package  Cookies_Page_Configuration_Page
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/incudes/set_cms_cookies.php
 */
require "includes/date_time.php";
// THIS COOKIE EXPIRATION TIME IS SET FOR 3 YEARS //
$expiration = 60*60*24*365*3;

if (!isset($_COOKIE["visits"])) {
    // THIS COOKIE CAPTURES THE FIRST TIME THE USER ENTERS THE WEB SITE //
    setcookie("visits", 1, time()+$expiration, "/", "localhost", false, false);
    
    // THIS COOKIE CAPTURES THE DATE AND TIME THE USER ENTERS THE WEB SITE //
    $date_time = date("F d Y  g:i:s a");
    setcookie("entryDateTime", $date_time, time()+$expiration, "/", "localhost", false, false);

    // THIS COOKIE CAPTURES THE PAGE THE USER ENTERS THE WEB SITE //
    $entryUrl = $_SERVER['PHP_SELF'];
    setcookie("entryPage", $entryUrl, time()+$expiration, "/", "localhost", false, false);

    // THIS VARIABLE IS SET TO A EMPTY VALUE OR SET TO THE URL THE USER CAME FROM //
    $cameFromURL = "";
    if (isset($_SERVER['HTTP_REFERER'])) {
        $cameFromURL = $_SERVER['HTTP_REFERER'];
    }
    // THIS COOKIE CAPTURES THE PAGE THE USER CAME FROM IF IT IS AVAILABLE //
    setcookie("cameFrom", $cameFromURL, time()+$expiration, "/", "localhost", false, false);

} elseif (!isset($_COOKIE["currentlyHere"])) {
    $v = $_COOKIE["visits"];
    $v++;
    // THIS COOKIE ADDS THE AMOUNT THE USER RETURNS TO THE WEB SITE AFTER LEAVING //
    setcookie("visits", $v, time()+$expiration, "/", "localhost", false, false);
}
// THIS COOKIE KEEPS TRACK WHEN THE USER IS ON THE WEB SITE //
$noExpieration = 0;
setcookie("currentlyHere", "true", $noExpieration, "/", "localhost", false, false);