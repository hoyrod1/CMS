<?php
/**
 * * @file
 * php version 8.2
 * Send Password Reset Page for CMS
 * 
 * @category CMS
 * @package  Send_Password_Reset_Page_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/send_password_reset.php
 */

require_once "includes/db_conn.php";

//=====================================================================//
/**
 * This function checks if the user exits in the database using the email
 *
 * @param string $email 
 * 
 * @access public  
 * 
 * @return mixed
 */
function verifyEmail($email)
{
    $connect = new Database("localhost", "root", "root", "cms");

    $sql  = "SELECT email FROM user_record WHERE email = :email";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $results = $stmt->rowcount();
    if ($results == 1) {
        return true;
    } else {
        return false;
    }
}
//=====================================================================//


//=====================================================================//
/**
 * This function sends email to reset users password
 *
 * @param string $email 
 * 
 * @access public  
 * 
 * @return mixed
 */
function resetEmail($email)
{

    $token      = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $exp_time   = date("Y-m-d H:i:s", time() + 60 * 10);

    $connect    = new Database("localhost", "root", "root", "cms");

    $sql        = "UPDATE user_record 
                   SET reset_token = :reset_token,
                       reset_token_expire_at = :reset_token_expire_at
                   WHERE email = :email";
    $stmt = $connect->conn()->prepare($sql);
    $stmt->bindValue(':reset_token', $token_hash, PDO::PARAM_STR);
    $stmt->bindValue(':reset_token_expire_at', $exp_time, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $results = $stmt->execute();

    if ($results) {
      
        $mail = include "mailer.php";
        
        $mail->setFrom("hoyrod1@gmail.com");
        $mail->FromName = "Rodney St. Cloud";
        $mail->addReplyTo('hoyrod1@gmail.com');
        $mail->addAddress($email);
        // $mail->Subjuct  = "Password reset";
    
        $mail->Body     = <<<END
        Click <a href="http://localhost:8888/cms/includes/change_password.php?token=$token">
                Click here
              </a> To reset your password
        END;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }

        return true;

    } else {
        return false;
    }
}
//=====================================================================//