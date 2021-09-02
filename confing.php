<?php 
	define('DB_HOST', 'localhost');
    define('USER_NAME', 'root');//root@localhost
    define('USER_PASS', '');
    define('DB_NAME', 'homework_db');
$comm = mysqli_connect(DB_HOST,USER_NAME,USER_PASS,DB_NAME);
//start session
session_start();

if(mysqli_connect_error()){
	die(mysqli_connect_error());
}
function logdein(){
	if(isset($_SESSION['id']) || isset($_Cookie['Username'])){
		return TRUE ; 
	}
}

?>