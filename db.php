<?php
// Database config - use env vars when available
$host = getenv('DB_HOST') ?: "mysql-env-wmion15tww.ap-south-1a.lb.nimbuz.tech";      // Nimbuz DB host
$user = getenv('DB_USER') ?: "root";       // MySQL username
$pass = getenv('DB_PASS') ?: "Test@123";   // MySQL password
$db   = getenv('DB_NAME') ?: "sample";     // Database name

$DB_TYPE = null;
$conn = null; // mysqli connection
$pdo = null;  // PDO connection

// Prefer mysqli if available for backward compatibility
if (function_exists('mysqli_connect')) {
    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("❌ Database connection failed (mysqli): " . mysqli_connect_error());
    }
    $DB_TYPE = 'mysqli';
    echo "✅ Database connected successfully (mysqli)<br>";

// Fallback to PDO if mysqli is not available
} elseif (class_exists('PDO')) {
    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $DB_TYPE = 'pdo';
        echo "✅ Database connected successfully (PDO)<br>";
    } catch (PDOException $e) {
        die("❌ Database connection failed (PDO): " . $e->getMessage());
    }

} else {
    die("❌ Neither mysqli nor PDO (pdo_mysql) extensions are available. Please enable the `mysqli` or `pdo_mysql` PHP extension.");
}
?>
