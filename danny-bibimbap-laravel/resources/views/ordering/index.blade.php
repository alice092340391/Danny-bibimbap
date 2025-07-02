<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danny Bibimbap - 線上點餐</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .menu-category h2 { border-bottom: 2px solid #dee2e6; padding-bottom: 10px; margin-top: 20px; }
        .cart { position: sticky; top: 20px; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; }
        .quantity-controls button { width: 30px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-4">
        <h1>Danny Bibimbap</h1>
        <p class="lead">歡迎光臨！您的桌號是：<strong id="table-number" class="fs-4">{{ $tableNumber }}</strong></p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div id="menu-container">
                <div class="text-center p-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">載入中...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card cart">
                <div class="card-body">
                    <h4 class="card-title">我的購物車</h4>
                    <div id="cart-items">
                        <p class="text-muted">您的購物車是空的。</p>
                    </div>
                    <hr>
                    <h5>總計: NT$ <span id="total-price">0</span></h5>
                    <div class="d-grid mt-3">
                        <button id="submit-order-btn" class="btn btn-primary btn-lg" disabled>送出訂單</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const menuContainer = document.getElementById('menu-container');
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceEl = document.getElementById('total-price');
    const submitOrderBtn = document.getElementById('submit-order-btn');
    const tableNumber = document.getElementById('table-number').textContent;

    let menuData = {};
    let cart = []; 

    async function fetchMenu() {
        try {
            const response = await fetch('/api/menu'); 
            if (!response.ok) throw new Error('無法取得菜單');
            menuData = await response.json();
            renderMenu();
        } catch (error) {
            menuContainer.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    }

    function renderMenu() {
        menuContainer.innerHTML = '';
        for (const category in menuData) {
            const categoryDiv = document.createElement('div');
            categoryDiv.className = 'menu-category';
            categoryDiv.innerHTML = `<h2>${category}</h2>`;

            const listGroup = document.createElement('div');
            listGroup.className = 'list-group';

            menuData[category].forEach(item => {
                const itemEl = document.createElement('a');
                itemEl.href = '#';
                itemEl.className = 'list-group-item list-group-item-action';
                itemEl.innerHTML = `
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">${item.name}</h5>
                        <small>NT$ ${item.price}</small>
                    </div>
                    <p class="mb-1">${item.description || ''}</p>
                `;
                itemEl.addEventListener('click', (e) => {
                    e.preventDefault();
                    addToCart(item);
                });
                listGroup.appendChild(itemEl);
            });

            categoryDiv.appendChild(listGroup);
            menuContainer.appendChild(categoryDiv);
        }
    }

    function addToCart(item) {
        const existingItem = cart.find(cartItem => cartItem.id === item.id);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({ id: item.id, name: item.name, price: item.price, quantity: 1 });
        }
        updateCart();
    }

    function updateCart() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-muted">您的購物車是空的。</p>';
            submitOrderBtn.disabled = true;
        } else {
            cartItemsContainer.innerHTML = '';
            cart.forEach((item, index) => {
                const itemEl = document.createElement('div');
                itemEl.className = 'cart-item mb-2';
                itemEl.innerHTML = `
                    <span>${item.name}</span>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, -1)">-</button>
                        <span class="mx-2">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, 1)">+</button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemEl);
            });
            submitOrderBtn.disabled = false;
        }

        const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        totalPriceEl.textContent = total;
    }

    window.changeQuantity = (index, delta) => {
        cart[index].quantity += delta;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1); 
        }
        updateCart();
    }

    submitOrderBtn.addEventListener('click', async () => {
        if (cart.length === 0) return;

        const orderData = {
            tableNumber: tableNumber,
            items: cart.map(item => ({ id: item.id, quantity: item.quantity }))
        };

        submitOrderBtn.disabled = true;
        submitOrderBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 送出中...';

        try {
            const response = await fetch('/api/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (!response.ok) {
                const errorMsg = result.message || '訂單送出失敗，請稍後再試';
                alert(errorMsg);
                if (response.status === 400) {
                    location.reload();
                }
            } else {
                alert(result.message);
                cart = [];
                updateCart();
                location.reload();
            }

        } catch (error) {
            alert('網路連線錯誤，請檢查您的網路。');
        } finally {
             submitOrderBtn.disabled = false;
             submitOrderBtn.textContent = '送出訂單';
        }
    });

    fetchMenu();
});
</script>

</body>
</html>