<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email jest wymagany";
    }
    
    if (empty($password)) {
        $errors[] = "Hasło jest wymagane";
    }
    
    if (empty($errors)) {
        // Check if user exists in session storage
        if (isset($_SESSION['users'][$email])) {
            $user = $_SESSION['users'][$email];
            if ($user['password'] === $password) { // In a real app, we'd use password_verify()
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Nieprawidłowe hasło";
            }
        } else {
            $errors[] = "Użytkownik nie istnieje";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: logowanie.php");
        exit();
    }
}
?> 