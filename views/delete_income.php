<?php
session_start();
require '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM income WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Income deleted successfully!';
    } else {
        $_SESSION['message'] = 'Error: Could not delete income.';
    }
    $stmt->close();
    $conn->close();
    header("Location: view_income.php");
    exit();
}
?>
