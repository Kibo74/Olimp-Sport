<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username   = "root";
$password   = "";
$basename   = "olimp_sport";

$dbc = mysqli_connect($servername, $username, $password, $basename, 3307)
    or die('Greska pri spajanju na MySQL ' . mysqli_connect_error());

mysqli_set_charset($dbc, "utf8mb4");
