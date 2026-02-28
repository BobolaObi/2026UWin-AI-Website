<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function get_client_ip(): string
{
    $ip = '';

    if (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = (string) $_SERVER['REMOTE_ADDR'];
    }

    return substr($ip, 0, 64);
}

function get_user_agent(): string
{
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? (string) $_SERVER['HTTP_USER_AGENT'] : '';
    return substr($ua, 0, 255);
}

function audit_log(int $admin_user_id, string $action, ?string $details = null): void
{
    $pdo = get_db();
    $stmt = $pdo->prepare(
        'INSERT INTO admin_audit_log (admin_user_id, action, details, ip_address, user_agent)
         VALUES (:admin_user_id, :action, :details, :ip_address, :user_agent)'
    );
    $stmt->execute([
        ':admin_user_id' => $admin_user_id,
        ':action' => $action,
        ':details' => $details,
        ':ip_address' => get_client_ip(),
        ':user_agent' => get_user_agent(),
    ]);
}

