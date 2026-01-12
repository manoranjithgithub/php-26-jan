<?php
include "db.php";

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
?>
