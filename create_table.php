<?php
include "db.php";

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    if ($DB_TYPE === 'mysqli') {
        if (mysqli_query($conn, $sql)) {
            echo "✅ Table 'users' created successfully";
        } else {
            echo "❌ Error creating table: " . mysqli_error($conn);
        }
    } else {
        $pdo->exec($sql);
        echo "✅ Table 'users' created successfully";
    }
} catch (PDOException $e) {
    echo "❌ Error creating table: " . $e->getMessage();
}
?>
