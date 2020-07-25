<?php

$mysql_host ='localhost';
$mysql_user='root';
$mysql_password='';

$connection=mysqli_connect($mysql_host,$mysql_user,$mysql_password);

if(!$connection){
	error_log("Failed to connect to MYSQL:");
	die("Internal server error");

}

$db_select=mysqli_select_db($connection,'nudge');
if(!$db_select){
	error_log("database selection failed: ".mysqli_error($connection));
	die('Internal server error');
}

// echo "connection success";

?>