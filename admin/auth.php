<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

function start_admin_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_name(SESSION_NAME);
    session_start();
}

function is_admin_logged_in(): bool
{
    start_admin_session();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_admin_login(): void
{
    if (is_admin_logged_in()) {
        return;
    }

    header('Location: /admin/login.php', true, 302);
    exit;
}

