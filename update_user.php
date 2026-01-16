<?php
include "db.php";

$id    = $_POST['id'] ?? null;
$name  = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;

if (!$id || !$name || !$email) {
    echo "❌ Missing id, name or email";
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE users 
         SET name = :name, email = :email 
         WHERE id = :id"
    );

    $stmt->execute([
        ':id'    => $id,
        ':name'  => $name,
        ':email' => $email
    ]);

    echo "✅ User updated successfully";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
