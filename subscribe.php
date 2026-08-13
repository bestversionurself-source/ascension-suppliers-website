<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

if (!is_post()) {
    redirect('/');
}

verify_csrf();

$referer = (string)($_SERVER['HTTP_REFERER'] ?? '');
$refererParts = parse_url($referer);
$currentHost = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
$refererHost = strtolower((string)($refererParts['host'] ?? ''));
$returnPath = '/';
if ($refererHost !== '' && preg_replace('/:\d+$/', '', $currentHost) === $refererHost) {
    $candidate = (string)($refererParts['path'] ?? '/');
    if (str_starts_with($candidate, '/') && !str_starts_with($candidate, '//')) {
        $returnPath = $candidate;
    }
}

function subscription_result(bool $ok, string $message, string $returnPath): never {
    $_SESSION['subscribe_flash'] = ['ok' => $ok, 'message' => $message];
    redirect($returnPath . '#footer-subscribe');
}

if (trim((string)($_POST['website'] ?? '')) !== '') {
    subscription_result(true, 'Thank you for subscribing.', $returnPath);
}

$now = time();
$lastAttempt = (int)($_SESSION['subscribe_last_attempt'] ?? 0);
if ($lastAttempt > 0 && ($now - $lastAttempt) < 5) {
    subscription_result(false, 'Please wait a few seconds and try again.', $returnPath);
}
$_SESSION['subscribe_last_attempt'] = $now;

$emailValue = strtolower(trim((string)($_POST['email'] ?? '')));
$email = filter_var($emailValue, FILTER_VALIDATE_EMAIL);
if (!$email || strlen($emailValue) > 190) {
    subscription_result(false, 'Please enter a valid email address.', $returnPath);
}

try {
    db()->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(190) NOT NULL,
        status ENUM('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
        ip_hash CHAR(64) DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_subscribers_email (email),
        INDEX idx_subscribers_status (status),
        INDEX idx_subscribers_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $ipHash = hash_hmac(
        'sha256',
        (string)($_SERVER['REMOTE_ADDR'] ?? ''),
        (string)($config['app_key'] ?? $config['admin']['password_hash'] ?? csrf_token())
    );
    $statement = db()->prepare(
        "INSERT INTO subscribers (email, status, ip_hash)
         VALUES (?, 'subscribed', ?)
         ON DUPLICATE KEY UPDATE status = 'subscribed', ip_hash = VALUES(ip_hash), updated_at = CURRENT_TIMESTAMP"
    );
    $statement->execute([$email, $ipHash]);
    subscription_result(true, 'Thank you! You are now subscribed.', $returnPath);
} catch (Throwable $error) {
    error_log('Subscription failed: ' . $error->getMessage());
    subscription_result(false, 'We could not save your subscription right now. Please try again later.', $returnPath);
}
