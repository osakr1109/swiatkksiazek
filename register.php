<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    
    $errors = [];
    
    // Validation
    if (empty($name)) {
        $errors[] = "Imię i nazwisko jest wymagane";
    }
    
    if (empty($email)) {
        $errors[] = "Email jest wymagany";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Nieprawidłowy format email";
    }
    
    if (empty($password)) {
        $errors[] = "Hasło jest wymagane";
    } elseif (strlen($password) < 6) {
        $errors[] = "Hasło musi mieć minimum 6 znaków";
    }
    
    if ($password !== $password_confirm) {
        $errors[] = "Hasła nie są identyczne";
    }
    
    // Initialize users array if it doesn't exist
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }
    
    // Check if email already exists
    if (isset($_SESSION['users'][$email])) {
        $errors[] = "Ten email jest już zarejestrowany";
    }
    
    if (empty($errors)) {
        // Create new user
        $user_id = count($_SESSION['users']) + 1;
        $_SESSION['users'][$email] = [
            'id' => $user_id,
            'name' => $name,
            'email' => $email,
            'password' => $password // In a real app, we'd use password_hash()
        ];
        
        $_SESSION['success'] = "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
        header("Location: logowanie.php");
        exit();
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: logowanie.php");
        exit();
    }
}
?> 