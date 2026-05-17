<?php
require_once __DIR__ . '/includes/session.php';
session_unset();
session_destroy();
// Clear the remember-me cookie
setcookie('mishkat_user', '', time() - 3600, "/");
header("Location: index.php");
exit();
?>
