let cart;
try {
    cart = JSON.parse(localStorage.getItem('cart'));
    if (!Array.isArray(cart)) cart = [];
} catch (e) {
    cart = [];
}

function updateCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
}

function addToCart(book) {
    const existingItem = cart.find(item => item.id === book.id);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ ...book, quantity: 1 });
    }
    updateCart();
    showNotification('Książka dodana do koszyka!');
}

function removeFromCart(bookId) {
    cart = cart.filter(item => item.id !== bookId);
    updateCart();
    showNotification('Książka usunięta z koszyka!');
}

function updateQuantity(bookId, change) {
    const item = cart.find(item => item.id === bookId);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        updateCart();
    }
}

function updateCartUI() {
    const cartItems = document.querySelector('.cart-items');
    if (!cartItems) return;

    cartItems.innerHTML = cart.map(item => `
        <div class="cart-item">
            <img src="${item.image}" alt="${item.title}">
            <div class="item-details">
                <h3>${item.title}</h3>
                <p>${item.author}</p>
                <p class="price">${item.price} zł</p>
            </div>
            <div class="item-quantity">
                <button class="quantity-btn" onclick="updateQuantity('${item.id}', -1)">-</button>
                <span>${item.quantity}</span>
                <button class="quantity-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
            </div>
            <button class="remove-btn" onclick="removeFromCart('${item.id}')">Usuń</button>
        </div>
    `).join('');

    updateCartSummary();
}

function updateCartSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = subtotal > 0 ? 9.99 : 0;
    const total = subtotal + shipping;

    const summaryHTML = `
        <div class="summary-row">
            <span>Wartość produktów:</span>
            <span>${subtotal.toFixed(2)} zł</span>
        </div>
        <div class="summary-row">
            <span>Dostawa:</span>
            <span>${shipping.toFixed(2)} zł</span>
        </div>
        <div class="summary-row total">
            <span>Razem:</span>
            <span>${total.toFixed(2)} zł</span>
        </div>
        <button class="checkout-btn">Przejdź do płatności</button>
    `;

    const cartSummary = document.querySelector('.cart-summary');
    if (cartSummary) {
        cartSummary.innerHTML = `<h2>Podsumowanie zamówienia</h2>${summaryHTML}`;
    }

    const cartItems = document.querySelector('.cart-items');
    if (cartItems) {
        if (cart.length === 0) {
            cartItems.innerHTML = '<div class="cart-empty"><p>Twój koszyk jest pusty.</p></div>';
            if (cartSummary) {
                cartSummary.innerHTML = `<h2>Podsumowanie zamówienia</h2><div class="summary-row"><span>Wartość produktów:</span><span>0,00 zł</span></div><div class="summary-row"><span>Dostawa:</span><span>0,00 zł</span></div><div class="summary-row total"><span>Razem:</span><span>0,00 zł</span></div>`;
            }
        }
    }
}

function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                showError(input, 'To pole jest wymagane');
            } else {
                clearError(input);
            }

            if (input.type === 'email' && !isValidEmail(input.value)) {
                isValid = false;
                showError(input, 'Podaj prawidłowy adres email');
            }

            if (input.type === 'password' && input.value.length < 6) {
                isValid = false;
                showError(input, 'Hasło musi mieć minimum 6 znaków');
            }
        });

        if (isValid) {
            if (formId === 'login-form') {
                handleLogin(form);
            } else if (formId === 'register-form') {
                handleRegistration(form);
            } else if (formId === 'payment-form') {
                handlePayment(form);
            }
        }
    });
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showError(input, message) {
    const formGroup = input.parentElement;
    const error = formGroup.querySelector('.error-message') || document.createElement('div');
    error.className = 'error-message';
    error.textContent = message;
    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(error);
    }
    input.classList.add('error');
}

function clearError(input) {
    const formGroup = input.parentElement;
    const error = formGroup.querySelector('.error-message');
    if (error) {
        error.remove();
    }
    input.classList.remove('error');
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

function handlePayment(form) {
    const formData = new FormData(form);
    const cardNumber = formData.get('card-number');
    const expiry = formData.get('expiry');
    const cvv = formData.get('cvv');
    showNotification('Przetwarzanie płatności...', 'info');
    setTimeout(() => {
        if (validateCard(cardNumber, expiry, cvv)) {
            showNotification('Płatność zakończona sukcesem!', 'success');
            cart = [];
            updateCart();
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 2000);
        } else {
            showNotification('Błąd płatności. Sprawdź dane karty.', 'error');
        }
    }, 2000);
}

function validateCard(number, expiry, cvv) {
    return number.length === 16 && 
           /^\d{2}\/\d{2}$/.test(expiry) && 
           /^\d{3}$/.test(cvv);
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartUI();
    document.querySelectorAll('.book-card button').forEach(button => {
        button.addEventListener('click', (e) => {
            const card = e.target.closest('.book-card');
            const priceText = card.querySelector('.price').textContent.replace('zł', '').replace(',', '.').replace(/[^0-9.]/g, '').trim();
            const book = {
                id: card.dataset.id,
                title: card.querySelector('h3').textContent,
                author: card.querySelector('p').textContent,
                price: parseFloat(priceText),
                image: card.querySelector('img').src
            };
            addToCart(book);
        });
    });
    validateForm('login-form');
    validateForm('register-form');
    validateForm('payment-form');
}); 