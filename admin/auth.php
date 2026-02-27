<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/audit.php';

function start_admin_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $is_https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name(SESSION_NAME);
    session_start();
}

function is_admin_logged_in(): bool
{
    start_admin_session();
    return isset($_SESSION['admin_user_id'], $_SESSION['admin_username'])
        && is_int($_SESSION['admin_user_id'])
        && is_string($_SESSION['admin_username'])
        && $_SESSION['admin_user_id'] > 0
        && $_SESSION['admin_username'] !== '';
}

function require_admin_login(): void
{
    if (is_admin_logged_in()) {
        return;
    }

    header('Location: /admin/login.php', true, 302);
    exit;
}

function current_admin_user_id(): int
{
    if (!is_admin_logged_in()) {
        return 0;
    }

    return (int) $_SESSION['admin_user_id'];
}

function current_admin_username(): string
{
    if (!is_admin_logged_in()) {
        return '';
    }

    return (string) $_SESSION['admin_username'];
}

function find_admin_user_by_username(string $username): ?array
{
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = :username LIMIT 1');
    $stmt->execute([':username' => $username]);
    $row = $stmt->fetch();

    if (!is_array($row)) {
        return null;
    }

    return $row;
}

function complete_admin_login(int $admin_user_id, string $username): void
{
    start_admin_session();
    session_regenerate_id(true);

    $_SESSION['admin_user_id'] = $admin_user_id;
    $_SESSION['admin_username'] = $username;

    $pdo = get_db();
    $stmt = $pdo->prepare('UPDATE admin_users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id');
    $stmt->execute([':id' => $admin_user_id]);

    audit_log($admin_user_id, 'login');
}
