<?php

$serverName = "localhost";
$serverusername = "root";
$dBpassword = "";
$dBname = "project";

$conn = mysqli_connect($serverName, $serverusername, $dBpassword, $dBname);

if (!$conn) {
    die("Connection Failed :" . mysqli_connect_error());
}