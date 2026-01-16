<?php
include "db.php";

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();

    if ($users) {
        echo "<h3>Users List</h3>";
        foreach ($users as $row) {
            echo "ID: {$row['id']} | ";
            echo "Name: {$row['name']} | ";
            echo "Email: {$row['email']}<br>";
        }
    } else {
        echo "❌ No users found";
    }
} catch (PDOException $e) {
    echo "❌ Query failed: " . $e->getMessage();
}
