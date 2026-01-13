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
    if ($DB_TYPE === 'mysqli') {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param('ssi', $name, $email, $id);
        if ($stmt->execute()) {
            echo "✅ User updated successfully";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=:name, email=:email WHERE id=:id");
        $stmt->execute([':name' => $name, ':email' => $email, ':id' => $id]);
        echo "✅ User updated successfully";
    }
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
