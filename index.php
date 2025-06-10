<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Księgarnia Online</title>
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
        <section class="hero">
            <h1>Witaj w naszej księgarni!</h1>
            <p>Odkryj świat książek w najlepszych cenach</p>
        </section>

        <section class="featured-books">
            <h2>Polecane książki</h2>
            <div class="book-grid">
                <div class="book-card" data-id="1" data-title="Władca Pierścieni" data-author="J.R.R. Tolkien" data-price="49.99">
                    <div class="book-content">
                        <img src="ab67616d0000b2733159d157b1d3f13bbd9efbe0.jpg" alt="Władca Pierścieni">
                        <h3>Władca Pierścieni</h3>
                        <p>J.R.R. Tolkien</p>
                        <p class="price">49,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="2" data-title="Harry Potter" data-author="J.K. Rowling" data-price="39.99">
                    <div class="book-content">
                        <img src="9972090.png" alt="Harry Potter">
                        <h3>Harry Potter</h3>
                        <p>J.K. Rowling</p>
                        <p class="price">39,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
    </footer>

    <script src="script.js"></script>
</body>
</html> 