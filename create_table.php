<?php
include "db.php";

$sql = "
IF NOT EXISTS (
    SELECT * FROM sysobjects WHERE name='users' AND xtype='U'
)
CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name NVARCHAR(100) NOT NULL,
    email NVARCHAR(150) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT GETDATE()
)
";

try {
    $pdo->exec($sql);
    echo "✅ Table 'users' created successfully";
} catch (PDOException $e) {
    echo "❌ Error creating table: " . $e->getMessage();
}
