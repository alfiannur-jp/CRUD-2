<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_crud";
$port = 8111;

// Create connection
$koneksi = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";