<?php
$db_connection = "mysql";
$db_host = "127.0.0.1";
$db_port = "3306";
$db_database = "shoplite";
$db_username = "root";
$db_password = "";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?> 