<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";

class MailConfigHelper{
    public static function getMailer():PHPMailer{
        $mail = new PHPMailer();
        // $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = "smtp.mailtrap.io";
        $mail->SMTPAuth = true;
        $mail->Username = "46b7dd8ec6dddc";
        $mail->Password = "";
        $mail->Port = 2525;
        $mail->SMTPSecure = 'tls';
        $mail->isHtml(true);
        $mail->setFrom("shraddhakeniya@gmail.com", "Shraddha Keniya");

        return $mail;
    }
}


?>