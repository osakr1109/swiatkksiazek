// Cart functionality
let cart = [];

// Initialize cart from localStorage
function initializeCart() {
    try {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            if (!Array.isArray(cart)) {
                cart = [];
            }
        }
    } catch (e) {
        console.error('Error loading cart:', e);
        cart = [];
    }
    updateCartUI();
}

function updateCart() {
    try {
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    } catch (e) {
        console.error('Error saving cart:', e);
        showNotification('Wystąpił błąd podczas zapisywania koszyka', 'error');
    }
}

function addToCart(book) {
    console.log('Adding book to cart:', book);
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
    }
    
    const existingItem = cart.find(item => item.id === book.id);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: book.id,
            title: book.title,
            author: book.author,
            price: book.price,
            image: book.image,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    console.log('Updated cart:', cart);
    
    if (document.getElementById('cart-items')) {
        displayCart();
    }
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

    // Optional: Show empty cart message
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

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });
        
        if (isValid) {
            form.submit();
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

// Notification system
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

// Payment handling
function handlePayment(form) {
    const formData = new FormData(form);
    const cardNumber = formData.get('card-number');
    const expiry = formData.get('expiry');
    const cvv = formData.get('cvv');

    // Simulate payment processing
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
    // Basic card validation
    return number.length === 16 && 
           /^\d{2}\/\d{2}$/.test(expiry) && 
           /^\d{3}$/.test(cvv);
}

// Clean up invalid items from localStorage cart
function cleanCartStorage() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (!Array.isArray(cart)) {
        cart = [];
    }
    // Only keep items with required properties
    cart = cart.filter(item => item && typeof item === 'object' && item.id && item.title && item.price);
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Call cleanCartStorage on page load
cleanCartStorage();

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart
    initializeCart();

    // Initialize cart display if on cart page
    if (document.getElementById('cart-items')) {
        displayCart();
    }

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.book-card');
            if (!card) return;

            const bookData = {
                id: card.dataset.id,
                title: card.dataset.title,
                author: card.dataset.author,
                price: card.dataset.price,
                image: card.querySelector('img').src
            };

            if (!bookData.id || !bookData.title || !bookData.price) {
                console.error('Invalid book data:', bookData);
                return;
            }

            addToCart(bookData);
        });
    });

    // Show description functionality
    document.querySelectorAll('.show-description').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.book-card');
            const description = card.querySelector('.description');
            description.style.display = description.style.display === 'block' ? 'none' : 'block';
            this.textContent = description.style.display === 'block' ? 'Ukryj opis' : 'Zobacz opis';
        });
    });

    // Card click functionality
    document.querySelectorAll('.book-card').forEach(card => {
        card.addEventListener('click', function() {
            const description = this.querySelector('.description');
            description.style.display = description.style.display === 'block' ? 'none' : 'block';
            const button = this.querySelector('.show-description');
            button.textContent = description.style.display === 'block' ? 'Ukryj opis' : 'Zobacz opis';
        });
    });

    // Initialize form validation
    validateForm('login-form');
    validateForm('register-form');
    validateForm('payment-form');
});

function displayCart() {
    console.log('Displaying cart...');
    const cartItems = document.getElementById('cart-items');
    const cartSummary = document.getElementById('cart-summary');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    console.log('Cart from localStorage:', cart);
    
    if (cartItems) {
        cartItems.innerHTML = '';
        
        if (cart.length === 0) {
            cartItems.innerHTML = '<p class="empty-cart">Twój koszyk jest pusty</p>';
            if (cartSummary) {
                cartSummary.innerHTML = `
                    <h3>Podsumowanie</h3>
                    <p>Liczba produktów: 0</p>
                    <p>Łączna kwota: 0,00 zł</p>
                `;
            }
            return;
        }
        
        let total = 0;
        
        cart.forEach(item => {
            if (!item || typeof item !== 'object' || !item.price) {
                console.error('Invalid item in cart:', item);
                return;
            }

            // Convert price to number, handling both string and number formats
            const price = typeof item.price === 'string' 
                ? parseFloat(item.price.replace('zł', '').trim())
                : parseFloat(item.price);

            if (isNaN(price)) {
                console.error('Invalid price for item:', item);
                return;
            }

            const itemTotal = price * item.quantity;
            total += itemTotal;
            
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.title}">
                <div class="item-details">
                    <h3>${item.title}</h3>
                    <p>${item.author}</p>
                    <p class="price">${price.toFixed(2)} zł</p>
                </div>
                <div class="quantity-controls">
                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                </div>
                <button class="remove-btn" onclick="removeFromCart('${item.id}')">Usuń</button>
            `;
            cartItems.appendChild(itemElement);
        });
        
        if (cartSummary) {
            cartSummary.innerHTML = `
                <h3>Podsumowanie</h3>
                <p>Liczba produktów: ${cart.reduce((sum, item) => sum + item.quantity, 0)}</p>
                <p>Łączna kwota: ${total.toFixed(2)} zł</p>
            `;
        }
    }
}

function updateQuantity(id, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(id);
        return;
    }
    
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
    }
    
    const item = cart.find(item => item.id === id);
    
    if (item) {
        item.quantity = newQuantity;
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCart();
    }
}

function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Ensure cart is an array
    if (!Array.isArray(cart)) {
        cart = [];
    }
    
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();
}

// Initialize form validation
validateForm('register-form');
validateForm('payment-form');

// Form validation
const registerForm = document.getElementById('register-form');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        const password = this.querySelector('input[name="password"]').value;
        const confirmPassword = this.querySelector('input[name="confirm_password"]').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Hasła nie są identyczne!');
        }
    });
}

const paymentForm = document.getElementById('payment-form');
if (paymentForm) {
    paymentForm.addEventListener('submit', function(e) {
        const cardNumber = this.querySelector('input[name="card_number"]').value;
        if (!/^\d{16}$/.test(cardNumber)) {
            e.preventDefault();
            alert('Nieprawidłowy numer karty!');
        }
    });
} 