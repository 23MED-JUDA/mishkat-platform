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

    #[\ReturnTypeWillChange]
    public function read($id): string|false {
        $stmt = $this->db->prepare("SELECT data FROM php_sessions WHERE id = ?");
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
        $stmt = $this->db->prepare("REPLACE INTO php_sessions (id, access, data) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $id, $access, $data);
        return $stmt->execute();
    }

    public function destroy($id): bool {
        $stmt = $this->db->prepare("DELETE FROM php_sessions WHERE id = ?");
        $stmt->bind_param("s", $id);
        return $stmt->execute();
    }

    public function gc($max_lifetime): int|false {
        $old = time() - $max_lifetime;
        $stmt = $this->db->prepare("DELETE FROM php_sessions WHERE access < ?");
        $stmt->bind_param("i", $old);
        if ($stmt->execute()) {
            return $stmt->affected_rows;
        }
        return false;
    }
}

$handler = new DatabaseSessionHandler($conn);
session_set_save_handler($handler, true);

// Start the session securely
session_start();
?>
