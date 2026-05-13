<?php
/**
 * Mishkat Platform — Vercel Entry Point (Front Controller)
 * All requests are routed through this file.
 */

// Set working directory to project root (one level up from /api)
chdir(dirname(__DIR__));

// Start session
session_start();

// Parse the requested path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';
$query = $_SERVER['QUERY_STRING'] ?? '';
if ($query) parse_str($query, $_GET);

// Serve static-like PHP routes
$routes = [
    '/'          => 'index.php',
    '/login'     => 'login.php',
    '/register'  => 'register.php',
    '/dashboard' => 'dashboard.php',
    '/logout'    => 'logout.php',
    '/about'     => 'about.php',
    '/contact'   => 'contact.php',
];

if (isset($routes[$path])) {
    $file = $routes[$path];
    if (file_exists($file)) {
        // Close the session started above so the included file can restart it
        session_write_close();
        require $file;
        exit;
    }
}

// Fallback: try to serve the path as a PHP file
$candidate = ltrim($path, '/') . '.php';
if (file_exists($candidate)) {
    session_write_close();
    require $candidate;
    exit;
}

// Also try without .php extension
$candidate2 = ltrim($path, '/');
if (file_exists($candidate2 . '.php')) {
    session_write_close();
    require $candidate2 . '.php';
    exit;
}

// 404
http_response_code(404);
session_write_close();
require 'index.php'; // Show home page on 404
