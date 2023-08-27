const http = require('http');
const url = require('url');

const server = http.createServer((req, res) => {
    const { method, headers } = req;
    const requestUrl = url.parse(req.url, true);
    let body = '';

    req.on('data', chunk => {
        body += chunk;
    });

    req.on('end', () => {
        const response = JSON.stringify({
            method: method,
            url: requestUrl.href,
            headers: headers,
            body: body,
        });

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(response);
    });
});

const PORT = 8081;
server.listen(PORT, '0.0.0.0', () => {
    console.log(`Server running at http://127.0.0.1:${PORT}`);
});
