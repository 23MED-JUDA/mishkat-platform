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

$handler = new DatabaseSessionHandler($conn);
session_set_save_handler($handler, true);

// Start the session securely
session_start();
?>
