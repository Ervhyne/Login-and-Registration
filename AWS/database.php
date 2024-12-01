<?php

$host = "sql307.infinityfree.com";
$dbname = "if0_37813162_Db_crud";
$username = "if0_37813162";
$password = "Catchers010904"; 

$mysqli = new mysqli($host,$username,$password,$dbname,3306); 
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;