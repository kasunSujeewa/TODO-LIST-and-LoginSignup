<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName="new_assignment";

if(!$connectionDb = mysqli_connect($dbHost,$dbUser,$dbPassword,$dbName)){
    die("connection Failed");
}

?>