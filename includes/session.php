<?php
// custom session handler using the database
$db_path = __DIR__ . '/db.php';
if (!file_exists($db_path)) {
    die("Database configuration not found.");
}
require_once $db_path;

class DatabaseSessionHandler implements SessionHandlerInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function open($path, $name): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    private function ensureTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS php_sessions (
            id varchar(128) NOT NULL,
            access int(10) unsigned DEFAULT NULL,
            data text,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    #[\ReturnTypeWillChange]
    public function read($id): string|false {
        try {
            $stmt = $this->db->prepare("SELECT data FROM php_sessions WHERE id = ?");
        } catch (mysqli_sql_exception $e) {
            $this->ensureTable();
            $stmt = $this->db->prepare("SELECT data FROM php_sessions WHERE id = ?");
        }

        if (!$stmt) return '';

        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row['data'];
            }
        }
        return '';
    }

    public function write($id, $data): bool {
        $access = time();
        try {
            $stmt = $this->db->prepare("REPLACE INTO php_sessions (id, access, data) VALUES (?, ?, ?)");
        } catch (mysqli_sql_exception $e) {
            $this->ensureTable();
            $stmt = $this->db->prepare("REPLACE INTO php_sessions (id, access, data) VALUES (?, ?, ?)");
        }

        if (!$stmt) return false;
        
        $stmt->bind_param("sis", $id, $access, $data);
        return $stmt->execute();
    }

    public function destroy($id): bool {
        try {
            $stmt = $this->db->prepare("DELETE FROM php_sessions WHERE id = ?");
            if (!$stmt) return false;
            $stmt->bind_param("s", $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            return true;
        }
    }

    public function gc($max_lifetime): int|false {
        $old = time() - $max_lifetime;
        try {
            $stmt = $this->db->prepare("DELETE FROM php_sessions WHERE access < ?");
            if (!$stmt) return false;
            $stmt->bind_param("i", $old);
            if ($stmt->execute()) {
                return $stmt->affected_rows;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
        return false;
    }
}

if (isset($db_connected) && $db_connected && $conn !== null) {
    $handler = new DatabaseSessionHandler($conn);
    session_set_save_handler($handler, true);
}

// Start the session securely if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// التأكد من وجود جدول التوكنات
function ensureRememberMeTable($conn) {
    $conn->query("CREATE TABLE IF NOT EXISTS `remember_me_tokens` (
        `id`         INT AUTO_INCREMENT PRIMARY KEY,
        `user_id`    INT NOT NULL,
        `token_hash` VARCHAR(255) NOT NULL UNIQUE,
        `expires_at` DATETIME NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (`user_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

// تسجيل دخول تلقائي
if (isset($db_connected) && $db_connected && $conn !== null) {
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['mishkat_remember'])) {
        $rawToken  = $_COOKIE['mishkat_remember'];
        $tokenHash = hash('sha256', $rawToken);

        try {
            // البحث عن التوكن
            $stmt = $conn->prepare(
                "SELECT rmt.id, rmt.user_id, rmt.expires_at,
                        u.name, r.name AS role, u.status
                 FROM remember_me_tokens rmt
                 JOIN users u ON u.id = rmt.user_id
                 JOIN roles r ON r.id = u.role_id
                 WHERE rmt.token_hash = ?
                   AND rmt.expires_at > NOW()"
            );
            $stmt->bind_param("s", $tokenHash);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if ($row['status'] === 'active') {
                    $_SESSION['user_id']   = $row['user_id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_role'] = $row['role'];

                    // تجديد التوكن
                    $newRaw   = bin2hex(random_bytes(32));
                    $newHash  = hash('sha256', $newRaw);
                    $newExpiry = date('Y-m-d H:i:s', time() + 30 * 24 * 3600);

                    $upd = $conn->prepare(
                        "UPDATE remember_me_tokens SET token_hash = ?, expires_at = ? WHERE id = ?"
                    );
                    $upd->bind_param("ssi", $newHash, $newExpiry, $row['id']);
                    $upd->execute();

                    setcookie(
                        'mishkat_remember',
                        $newRaw,
                        ['expires'  => time() + 30 * 24 * 3600,
                         'path'     => '/',
                         'httponly' => true,
                         'samesite' => 'Lax']
                    );
                } else {
                    // حساب معلق
                    $del = $conn->prepare("DELETE FROM remember_me_tokens WHERE token_hash = ?");
                    $del->bind_param("s", $tokenHash);
                    $del->execute();
                    setcookie('mishkat_remember', '', time() - 3600, '/');
                }
            } else {
                setcookie('mishkat_remember', '', time() - 3600, '/');
            }

            // تنظيف التوكنات المنتهية
            if (rand(1, 100) === 1) {
                $conn->query("DELETE FROM remember_me_tokens WHERE expires_at < NOW()");
            }

        } catch (Exception $e) {
            // تجاهل الخطأ
        }
    }
}

// حذف كوكيز قديم
if (isset($_COOKIE['mishkat_user'])) {
    setcookie('mishkat_user', '', time() - 3600, '/');
}
