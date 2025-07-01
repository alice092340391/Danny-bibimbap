<?php
//會自動抓伺服器的區網 IP（例如 192.168.x.x），就不用每次手動改IP。
// 取得伺服器的區網 IP（IPv4）
function getLocalIp() {
    $ip = $_SERVER['SERVER_ADDR'] ?? 'localhost';
    // 假如 SERVER_ADDR 是 ::1 (IPv6 localhost)，改用 getenv
    if ($ip === '::1') {
        // 這裡可改成你電腦區網 IP，或用更複雜方法抓取
        $ip = getHostByName(getHostName());
    }
    return $ip;
}

$serverIp = getLocalIp();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <title>產生點餐 QR Code (PHP版)</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8f0;
      text-align: center;
      padding: 40px;
    }
    input[type="number"] {
      padding: 10px;
      font-size: 1.2rem;
      width: 150px;
    }
    button {
      padding: 10px 20px;
      font-size: 1.2rem;
      margin-left: 10px;
    }
    #qrcode {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <h1>產生點餐 QR Code (PHP自動抓IP版)</h1>
  <p>伺服器 IP：<strong id="serverIp"><?php echo htmlspecialchars($serverIp); ?></strong></p>
  <p>請輸入桌號：</p>
  <input type="number" id="tableInput" min="1" max="100" placeholder="例如：3" onkeydown="if(event.key==='Enter'){generateQRCode();}" />
  <button onclick="generateQRCode()">產生</button>

  <div id="qrcode"></div>
  <p id="qrLink" style="margin-top: 20px;"></p>

  <script>
    function generateQRCode() {
      const tableNumber = document.getElementById('tableInput').value.trim();
      const qrcodeContainer = document.getElementById('qrcode');
      const qrLink = document.getElementById('qrLink');
      qrcodeContainer.innerHTML = '';
      qrLink.innerHTML = '';

      if (!tableNumber || isNaN(tableNumber) || parseInt(tableNumber) < 1 || parseInt(tableNumber) > 100) {
        alert("請輸入有效的桌號（1-100）！");
        return;
      }

      // 從頁面讀取自動抓到的伺服器 IP
      const serverIp = document.getElementById('serverIp').textContent;
      const url = `http://${serverIp}/frontend/danny_bibimbap/danny-bibimbap.html?table=${tableNumber}`;

      new QRCode(qrcodeContainer, {
        text: url,
        width: 256,
        height: 256,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
      });

      qrLink.innerHTML = `掃描網址：<br><a href="${url}" target="_blank">${url}</a>`;
    }
  </script>
</body>
</html>
