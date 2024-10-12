<?php
$host = 'localhost';
$dbname = 'finance_manager';
$username = 'root';
$password = ''; // replace with your database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
