<?php
/**
 * Mishkat Platform — Vercel Entry Point (Front Controller) v1.2
 * All requests are routed through this file.
 */

// Set working directory to project root (one level up from /api)
chdir(dirname(__DIR__));

// Start session
require_once __DIR__ . '/../includes/session.php';

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

// Fallback 1: try to serve the path directly if it already ends in .php
$candidate = ltrim($path, '/');
if (str_ends_with($candidate, '.php') && file_exists($candidate)) {
    session_write_close();
    require $candidate;
    exit;
}

// Fallback 2: try adding .php
$candidate2 = $candidate . '.php';
if (file_exists($candidate2)) {
    session_write_close();
    require $candidate2;
    exit;
}

// 404
http_response_code(404);
session_write_close();
require 'index.php'; // Show home page on 404
