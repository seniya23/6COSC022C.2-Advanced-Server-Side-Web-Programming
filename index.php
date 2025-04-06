<?php
require 'auth.php';
require 'database.php';
require 'middleware.php';

// Route the request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/register' && $requestMethod === 'POST') {
    registerUser();
} elseif ($requestUri === '/login' && $requestMethod === 'POST') {
    loginUser();
} elseif ($requestUri === '/generate-api-key' && $requestMethod === 'POST') {
    generateApiKey();
} elseif (preg_match('/^\/country\/(.+)$/', $requestUri, $matches) && $requestMethod === 'GET') {
    fetchCountryData($matches[1]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
?>