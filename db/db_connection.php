<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rexx_code_challenge";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // PDO error mode will be set to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
