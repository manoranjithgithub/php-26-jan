<?php
$host = "tools-a-mysql.env-te2ifplcfh";      // Nimbuz DB host
$user = "sa";       // MySQL username
$pass = "Test@12345";   // MySQL password
$db   = "sample";       // Database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

echo "✅ Database connected successfully<br>";
?>
