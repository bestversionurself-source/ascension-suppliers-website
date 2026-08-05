<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly' => true, 'secure' => !empty($_SERVER['HTTPS']), 'samesite' => 'Lax']);
    session_start();
}

$local = __DIR__ . '/../config/config.local.php';
if (!is_file($local)) {
    http_response_code(500);
    exit('Configuration missing. Copy config/config.example.php to config/config.local.php.');
}
$config = require $local;

function db(): PDO {
    static $pdo;
    global $config;
    if (!$pdo) {
        $d = $config['db'];
        $dsn = "mysql:host={$d['host']};dbname={$d['name']};charset={$d['charset']}";
        $pdo = new PDO($dsn, $d['user'], $d['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}

function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(419); exit('Invalid or expired request.');
    }
}
function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function json_response(array $data, int $status = 200): never {
    http_response_code($status); header('Content-Type: application/json'); echo json_encode($data); exit;
}
function admin_required(): void {
    if (empty($_SESSION['admin'])) redirect('/admin/login.php');
}

$packages = [
    'starter' => ['name' => 'Starter Website', 'price' => 1500000, 'deposit' => 450000, 'label' => '₹15,000'],
    'business' => ['name' => 'Business Website', 'price' => 3000000, 'deposit' => 900000, 'label' => '₹30,000'],
    'ecommerce' => ['name' => 'E-Commerce Website', 'price' => 5500000, 'deposit' => 1650000, 'label' => '₹55,000'],
];

