<?php
/**
 * * @file
 * php version 8.2
 * Mailer Page for CMS
 * 
 * @category CMS
 * @package  Mailer_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/mailer.php
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";


$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;

// $mail->SMTPDebug  = 0;
// $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
$mail->SMTPDebug  = SMTP::DEBUG_OFF;

$mail->Host       = "smtp.gmail.com";

$mail->SMTPSecure = "ssl";
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port       = "465";
$mail->Username   = "hoyrod1@gmail.com";
$mail->Password   = "gvuv mghj igxj ddsp";

$mail->isHTML(true);

return $mail;
