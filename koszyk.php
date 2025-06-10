<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - Księgarnia Online</title>
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

    <main>
        <h1>Twój koszyk</h1>
        
        <div class="cart-container">
            <div id="cart-items" class="cart-items">
                <!-- Elementy koszyka będą generowane dynamicznie przez JavaScript -->
            </div>

            <div id="cart-summary" class="cart-summary">
                <h2>Podsumowanie zamówienia</h2>
                <!-- Podsumowanie będzie generowane dynamicznie przez JavaScript -->
            </div>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="payment-form">
            <h2>Dane do płatności</h2>
            <form id="payment-form">
                <div class="form-group">
                    <label for="card-number">Numer karty:</label>
                    <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry">Data ważności:</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/RR" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Imię i nazwisko:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                </div>
                <button type="submit">Zapłać</button>
            </form>
        </div>
        <?php else: ?>
        <div class="login-prompt">
            <h2>Aby dokonać zakupu, zaloguj się lub zarejestruj</h2>
            <div class="auth-buttons">
                <a href="logowanie.php" class="btn">Zaloguj się</a>
                <a href="register.php" class="btn">Zarejestruj się</a>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer>
    </footer>

    <script src="script.js"></script>
</body>
</html> 