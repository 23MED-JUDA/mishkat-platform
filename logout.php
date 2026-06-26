<?php
require_once __DIR__ . '/includes/session.php';

// حذف التوكن من قاعدة البيانات إذا كان مسجلاً
if (isset($_COOKIE['mishkat_remember'])) {
    $rawToken = $_COOKIE['mishkat_remember'];
    $tokenHash = hash('sha256', $rawToken);
    try {
        $stmt = $conn->prepare("DELETE FROM remember_me_tokens WHERE token_hash = ?");
        $stmt->bind_param("s", $tokenHash);
        $stmt->execute();
    } catch (Exception $e) {
        
    }
}

// مسح الكوكيز الخاصة بتذكرني
setcookie('mishkat_remember', '', time() - 3600, "/");
setcookie('mishkat_user', '', time() - 3600, "/");

// تدمير الجلسة
session_unset();
session_destroy();

header("Location: index.php");
exit();
