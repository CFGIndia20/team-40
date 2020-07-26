<?php
require_once "app/init.php";
session_unset();
session_destroy();
$auth->signout();
header("Location: index.php");
?>
