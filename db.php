<?php
$host = getenv('DB_HOST') ?: "sa-mysql.env-0smnu91sqb";
$user = getenv('DB_USER') ?: "sa";
$pass = getenv('DB_PASS') ?: "Test@123";
$db   = getenv('DB_NAME') ?: "sample";

try {
    $dsn = "sqlsrv:Server=$host;Database=$db";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo "✅ Database connected successfully (MSSQL PDO)<br>";

} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
