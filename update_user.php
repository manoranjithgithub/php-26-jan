<?php
include "db.php";

$id    = $_POST['id'];
$name  = $_POST['name'];
$email = $_POST['email'];

$sql = "UPDATE users 
        SET name='$name', email='$email' 
        WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "✅ User updated successfully";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
