<?php
include "db.php";

$name  = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;

if (!$name || !$email) {
    echo "❌ Missing name or email";
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email) VALUES (:name, :email)"
    );
    $stmt->execute([
        ':name'  => $name,
        ':email' => $email
    ]);

    echo "✅ User created successfully";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
