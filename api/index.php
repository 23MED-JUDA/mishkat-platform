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

// Serve mishkah-app static files if they exist
$candidate_static = ltrim($path, '/');
if (str_starts_with($candidate_static, 'mishkah-app/') && file_exists($candidate_static) && !is_dir($candidate_static)) {
    $mime_types = [
        'html' => 'text/html',
        'js'   => 'application/javascript',
        'css'  => 'text/css',
        'json' => 'application/json',
        'svg'  => 'image/svg+xml',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
    ];
    $ext = pathinfo($candidate_static, PATHINFO_EXTENSION);
    header('Content-Type: ' . ($mime_types[$ext] ?? 'text/plain'));
    readfile($candidate_static);
    exit;
}

if (isset($routes[$path])) {
    $file = $routes[$path];
    if (file_exists($file)) {
        // Close the session started above so the included file can restart it

        require $file;
        exit;
    }
}

// Fallback 1: try to serve the path directly if it already ends in .php
$candidate = ltrim($path, '/');
if (str_ends_with($candidate, '.php') && file_exists($candidate)) {
    require $candidate;
    exit;
}

// Fallback 2: try adding .php
$candidate2 = $candidate . '.php';
if (file_exists($candidate2)) {
    require $candidate2;
    exit;
}

http_response_code(404);
require 'index.php'; // Show home page on 404
