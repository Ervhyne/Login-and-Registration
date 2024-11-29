<?php

$host = '0.0.0.0';
$dbname = "db_crud";
$username = "root";
$password = "root"; 

$mysqli = new mysqli($host,$username,$password,$dbname,3306); 
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;