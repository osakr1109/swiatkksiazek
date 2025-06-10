<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Księgarnia Online</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Księgarnia Online</div>
            <ul class="nav-links">
                <li><a href="index.php">Strona Główna</a></li>
                <li><a href="kategorie.php">Kategorie</a></li>
                <li><a href="koszyk.php">Koszyk</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-info">
                        <span class="login-text">Zalogowany jako:</span>
                        <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                    </li>
                    <li><a href="logout.php">Wyloguj się</a></li>
                <?php else: ?>
                    <li><a href="logowanie.php">Zaloguj się</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="auth-container">
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-messages">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="auth-box">
            <h2>Logowanie</h2>
            <form action="login.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Hasło:</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="submit">Zaloguj się</button>
            </form>
        </div>

        <div class="auth-box">
            <h2>Rejestracja</h2>
            <form action="register.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="register-name">Imię i nazwisko:</label>
                    <input type="text" id="register-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="register-email">Email:</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="register-password">Hasło:</label>
                    <input type="password" id="register-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="register-password-confirm">Potwierdź hasło:</label>
                    <input type="password" id="register-password-confirm" name="password-confirm" required>
                </div>
                <button type="submit">Zarejestruj się</button>
            </form>
        </div>
    </main>

    <footer>
    </footer>

    <script src="script.js"></script>
</body>
</html> 