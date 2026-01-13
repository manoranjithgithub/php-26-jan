<?php
include "db.php";

if ($DB_TYPE === 'mysqli') {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h3>Users List</h3>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row['id'] . " | ";
            echo "Name: " . $row['name'] . " | ";
            echo "Email: " . $row['email'] . "<br>";
        }
    } else {
        echo "❌ No users found";
    }

} else {
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $rows = $stmt->fetchAll();

        if ($rows) {
            echo "<h3>Users List</h3>";
            foreach ($rows as $row) {
                echo "ID: " . $row['id'] . " | ";
                echo "Name: " . $row['name'] . " | ";
                echo "Email: " . $row['email'] . "<br>";
            }
        } else {
            echo "❌ No users found";
        }
    } catch (PDOException $e) {
        echo "❌ Query failed: " . $e->getMessage();
    }
}
?>
