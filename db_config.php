<?php

$host = "sql300.infinityfree.com";
$user = "if0_42385395";
$password = "lCxdkigTbEPT1d";
$database = "if0_42385395_MyPortfolio_Database";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
