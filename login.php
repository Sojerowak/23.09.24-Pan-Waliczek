<?php
session_start();
include('includes/db.php');
if ($_SERVER('REQUEST_METHOD') == 'POST') {
    $username = $_POST('username');
    $password = $_POST('password');
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Niepoprawne hasło!";
        }
    }
}
?>