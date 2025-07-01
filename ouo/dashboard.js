// 首頁畫面自動顯示從資料庫抓來的 即時數據
document.addEventListener('DOMContentLoaded', function () {
    fetch('dashboard-data.php')
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('.card')[0].querySelector('p').textContent = data.orderCount;
            document.querySelectorAll('.card')[1].querySelector('p').textContent = 'NT$ ' + data.salesTotal.toLocaleString();
            document.querySelectorAll('.card')[2].querySelector('p').textContent = data.newCustomers;
            document.querySelectorAll('.card')[3].querySelector('p').textContent = data.pendingOrders;

            // 最新訂單列表
            const latestOrdersList = document.querySelectorAll('.card')[6].querySelector('ul');
            latestOrdersList.innerHTML = '';
            data.latestOrders.forEach(order => {
                const li = document.createElement('li');
                li.textContent = `訂單 #${order.OrderID} - ${order.minutesAgo} 分鐘前`;
                latestOrdersList.appendChild(li);
            });
        })
        .catch(error => {
            console.error('載入儀表板資料失敗:', error);
        });
});