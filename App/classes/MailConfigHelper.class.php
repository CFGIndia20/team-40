<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'vendor/autoload.php';

class MailConfigHelper{
    public static function getMailer():PHPMailer{
            $mail = new PHPMailer();
            //$mail->SMTPDebug= 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'a8e6087bdcabd1';
            $mail->Password = '';
            $mail->Port = 2525;
            $mail->SMTPSecure = 'tls';
            $mail->isHTML(true);
            $mail->setFrom('awatramanipriyanka1@gmail.com', 'Priyanka');

            return $mail;
    }
}

?>