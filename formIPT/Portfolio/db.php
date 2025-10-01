<?php

$server = "sql312.infinityfree.com";
$username = "if0_40066692";
$password = "quimba12345";
$dbname = "if0_40066692_db_portfolio";

$conn = mysqli_connect($server, $username, $password, $dbname);

if(!$conn){
    die("Connection Failed:".mysqli_connect());
}

?>