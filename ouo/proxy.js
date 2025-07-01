const { createProxyMiddleware } = require('http-proxy-middleware');
const express = require('express');
const app = express();

app.use('/ouo', createProxyMiddleware({ target: 'http://localhost', changeOrigin: true }));

app.listen(3000, () => {
  console.log('Proxy server listening on port 3000');
});
