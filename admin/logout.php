<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

start_admin_session();

$admin_user_id = current_admin_user_id();
if ($admin_user_id > 0) {
    audit_log($admin_user_id, 'logout');
}

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        [
            'expires' => time() - 3600,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => (bool) $params['secure'],
            'httponly' => (bool) $params['httponly'],
            'samesite' => 'Lax',
        ]
    );
}

session_destroy();

header('Location: /admin/login.php', true, 302);
exit;
