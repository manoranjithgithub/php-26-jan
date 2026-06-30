<?php
function loadEnvFile(string $filePath): void
{
    if (!is_file($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        [$name, $value] = $parts;
        $name = trim($name);
        $value = trim($value);

        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }

        if (getenv($name) === false) {
            putenv("{$name}={$value}");
        }

        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
        }

        if (!array_key_exists($name, $_SERVER)) {
            $_SERVER[$name] = $value;
        }
    }
}

function getConfigValue(string $name, string $default = ''): string
{
    $value = getenv($name);
    if ($value !== false && $value !== '') {
        return $value;
    }

    if (array_key_exists($name, $_ENV) && $_ENV[$name] !== '') {
        return (string) $_ENV[$name];
    }

    if (array_key_exists($name, $_SERVER) && $_SERVER[$name] !== '') {
        return (string) $_SERVER[$name];
    }

    return $default;
}

loadEnvFile(__DIR__ . DIRECTORY_SEPARATOR . '.env');

// Database config - use env vars when available, with .env as local fallback
$host = getConfigValue('DB_HOST', '127.0.0.1');
$user = getConfigValue('DB_USER', 'root');
$pass = getConfigValue('DB_PASS', '');
$db   = getConfigValue('DB_NAME', 'my_database');
$port = getConfigValue('DB_PORT', '3306');

$DB_TYPE = null;
$conn = null; // mysqli connection
$pdo = null;  // PDO connection

// Prefer mysqli if available for backward compatibility
if (function_exists('mysqli_connect')) {
    $conn = mysqli_connect($host, $user, $pass, $db, (int) $port);
    if (!$conn) {
        die("❌ Database connection failed (mysqli): " . mysqli_connect_error());
    }
    $DB_TYPE = 'mysqli';
    echo "✅ Database connected successfully (mysqli)<br>";

// Fallback to PDO if mysqli is not available
} elseif (class_exists('PDO')) {
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
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
