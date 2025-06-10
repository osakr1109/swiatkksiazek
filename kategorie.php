<?php
session_start();

// Ensure session is active but don't require login
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie - Księgarnia Online</title>
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
        <h1>Kategorie książek</h1>
        
        <section class="category">
            <h2>Fantasy</h2>
            <div class="book-grid">
                <div class="book-card" data-id="3" data-title="Epicka opowieść" data-author="Autor Nieznany" data-price="29.99">
                    <div class="book-content">
                        <img src="51P3NlbkUZL._SY466_.jpg" alt="Epicka opowieść">
                        <h3>Epicka opowieść</h3>
                        <p>Autor Nieznany</p>
                        <p class="price">29,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="4" data-title="Książka historyczna" data-author="Autor Nieznany" data-price="34.99">
                    <div class="book-content">
                        <img src="61x9NsZp3GL._AC_UF1000,1000_QL80_.jpg" alt="Książka historyczna">
                        <h3>Książka historyczna</h3>
                        <p>Autor Nieznany</p>
                        <p class="price">34,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="category">
            <h2>Kryminały</h2>
            <div class="book-grid">
                <div class="book-card" data-id="5" data-title="Millennium" data-author="Stieg Larsson" data-price="54.99">
                    <div class="book-content">
                        <img src="51P3NlbkUZL._SY466_.jpg" alt="Millennium">
                        <h3>Millennium</h3>
                        <p>Stieg Larsson</p>
                        <p class="price">54,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="6" data-title="Sherlock Holmes" data-author="Arthur Conan Doyle" data-price="34.99">
                    <div class="book-content">
                        <img src="51jJH4eNxLL._SY445_SX342_.jpg" alt="Sherlock Holmes">
                        <h3>Sherlock Holmes</h3>
                        <p>Arthur Conan Doyle</p>
                        <p class="price">34,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="category">
            <h2>Literatura obyczajowa</h2>
            <div class="book-grid">
                <div class="book-card" data-id="7" data-title="Mały Książę" data-author="Antoine de Saint-Exupéry" data-price="29.99">
                    <div class="book-content">
                        <img src="pobrane.png" alt="Mały Książę">
                        <h3>Mały Książę</h3>
                        <p>Antoine de Saint-Exupéry</p>
                        <p class="price">29,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="8" data-title="Biblia" data-author="Jane Austen" data-price="39.99">
                    <div class="book-content">
                        <img src="pobrane.jpg" alt="Bsiblia">
                        <h3>Biblia</h3>
                        <p>Jane Austen</p>
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

        <section class="category">
            <h2>Polityka</h2>
            <div class="book-grid">
                <div class="book-card" data-id="9" data-title="Gra o Tron" data-author="Stieg Larsson" data-price="54.99">
                    <div class="book-content">
                        <img src="zmencony-bylem-ale-zaglosowalem.webp" alt="Millennium">
                        <h3>Millennium</h3>
                        <p>Stieg Larsson</p>
                        <p class="price">54,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="10" data-title="Wiedźmin" data-author="Arthur Conan Doyle" data-price="34.99">
                    <div class="book-content">
                        <img src="polska-silna-historia-karol-nawrocki.jpg" alt="Sherlock Holmes">
                        <h3>Sherlock Holmes</h3>
                        <p>Arthur Conan Doyle</p>
                        <p class="price">34,99 zł</p>
                        <p class="description" style="display: none;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <div class="book-actions">
                            <button class="add-to-cart">Dodaj do koszyka</button>
                            <button class="show-description">Zobacz opis</button>
                        </div>
                    </div>
                </div>
                <div class="book-card" data-id="11" data-title="Sherlock Holmes" data-author="Arthur Conan Doyle" data-price="34.99">
                    <div class="book-content">
                        <img src="faszym.jpg" alt="Sherlock Holmes">
                        <h3>Sherlock Holmes</h3>
                        <p>Arthur Conan Doyle</p>
                        <p class="price">34,99 zł</p>
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