<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

if (!is_post()) {
    redirect('/');
}

verify_csrf();

$referer = (string)($_SERVER['HTTP_REFERER'] ?? '');
$parts = parse_url($referer);
$currentHost = preg_replace('/:\d+$/', '', strtolower((string)($_SERVER['HTTP_HOST'] ?? '')));
$refererHost = strtolower((string)($parts['host'] ?? ''));
$returnPath = '/';
if ($refererHost !== '' && $currentHost === $refererHost) {
    $candidate = (string)($parts['path'] ?? '/');
    if (str_starts_with($candidate, '/') && !str_starts_with($candidate, '//')) {
        $returnPath = $candidate;
    }
}

function finish_subscription(bool $ok, string $message, string $returnPath): never {
    $_SESSION['email_sub_flash'] = ['ok' => $ok, 'message' => $message];
    redirect($returnPath . '#newsletter');
}

if (trim((string)($_POST['company_website'] ?? '')) !== '') {
    finish_subscription(true, 'Thank you for subscribing.', $returnPath);
}

$now = time();
$lastAttempt = (int)($_SESSION['email_sub_last_attempt'] ?? 0);
if ($lastAttempt && ($now - $lastAttempt) < 5) {
    finish_subscription(false, 'Please wait a moment before trying again.', $returnPath);
}
$_SESSION['email_sub_last_attempt'] = $now;

$emailValue = strtolower(trim((string)($_POST['email'] ?? '')));
$email = filter_var($emailValue, FILTER_VALIDATE_EMAIL);
if (!$email || strlen($emailValue) > 190) {
    finish_subscription(false, 'Please enter a valid email address.', $returnPath);
}

try {
    db()->exec("CREATE TABLE IF NOT EXISTS email_sub (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL,
        status ENUM('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
        source_path VARCHAR(255) DEFAULT NULL,
        ip_hash CHAR(64) DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_email_sub_email (email),
        INDEX idx_email_sub_status (status),
        INDEX idx_email_sub_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $secret = (string)($config['app_key'] ?? $config['admin']['password_hash'] ?? csrf_token());
    $ipHash = hash_hmac('sha256', (string)($_SERVER['REMOTE_ADDR'] ?? ''), $secret);
    $statement = db()->prepare(
        "INSERT INTO email_sub (email, status, source_path, ip_hash)
         VALUES (?, 'subscribed', ?, ?)
         ON DUPLICATE KEY UPDATE
            status = 'subscribed',
            source_path = VALUES(source_path),
            ip_hash = VALUES(ip_hash),
            updated_at = CURRENT_TIMESTAMP"
    );
    $statement->execute([$email, substr($returnPath, 0, 255), $ipHash]);

    finish_subscription(true, 'Welcome! You have successfully subscribed.', $returnPath);
} catch (Throwable $error) {
    error_log('Email subscription failed: ' . $error->getMessage());
    finish_subscription(false, 'Subscription is temporarily unavailable. Please try again.', $returnPath);
}
