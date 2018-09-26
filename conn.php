<?php  
error_reporting(E_ALL); 
ini_set('display_errors', 1);
define("HOSTNAME", $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/");

$db = $conn = new mysqli("localhost", "clement", "clement123" , "park");
?>



