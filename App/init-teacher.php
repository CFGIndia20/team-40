<?php 
session_start(); //Session started

$app = __DIR__;
require_once "{$app}/classes/Hash.class.php";
require_once "{$app}/classes/ErrorHandler.class.php";
require_once "{$app}/classes/Validator.class.php";
require_once "{$app}/classes/database.class.php";
require_once "{$app}/classes/Auth-teacher.class.php";
require_once "{$app}/classes/TokenHandler.class.php";
require_once "{$app}/classes/UserHelper.class.php";
require_once "{$app}/classes/MailConfigHelper.class.php";

$hash = new Hash();
$database = new Database();
$auth = new Authteacher($database, $hash);
$errorHandler = new ErrorHandler();
$validation = new Validator($database, $errorHandler);
$tokenHandler = new TokenHandler($database, $hash);
$userHelper = new UserHelper($database);
$mail = MailConfigHelper::getMailer(); 
$tokenHandler->build();

if((isset($_COOKIE['token']) && $tokenHandler->isValid($_COOKIE['token'],1))){
    $token = $_COOKIE['token'];
    //I want the user or user id
    $user = $tokenHandler->getUserFromValidToken($token);
    // die(var_dump($user));

    $auth->setAuthSession($user->user_id);
}
?>