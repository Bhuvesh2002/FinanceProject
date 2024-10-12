<?php
session_start();
require '../config/db.php';

if ($_GET['action'] == 'register') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Registration successful!';
        header('Location: ../login.php');
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
        header('Location: ../register.php');
    }
    $stmt->close();

} elseif ($_GET['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['userid'] = $user['id'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['message'] = 'Login successful!';
            header('Location: ../views/dashboard.php');
        } else {
            $_SESSION['message'] = 'Invalid password!';
            header('Location: ../views/login.php');
        }
    } else {
        $_SESSION['message'] = 'User not found!';
        header('Location: ../views/login.php');
    }
    $stmt->close();
}

$conn->close();
?>
